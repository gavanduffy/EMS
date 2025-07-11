<?php

namespace App\Console\Commands\Addon;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallExamModule extends Command
{
    protected $signature = 'module:install-exam
        {--repo= : The repository URL} 
        {--package= : The composer package name}
        {--username= : Git username}
        {--token= : Git token}';

    protected $description = 'Installs a custom module from a private Git repository';

    public function handle()
    {
        $repo = $this->option('repo');
        $package = $this->option('package');
        $username = $this->option('username');
        $token = $this->option('token');

        if (!$repo || !$package || !$username || !$token) {
            $this->error('Missing one or more required options.');
            return 1;
        }

        // Step 1: Configure global Composer auth
        $cmd = "composer config --global github-oauth.github.com {$token}";
        exec($cmd, $output, $status);
        if ($status !== 0) {
            $this->error("Failed to configure Composer auth: " . implode("\n", $output));
            return 1;
        }

        // Step 2: Add repository to composer.json
        $parsed = parse_url($repo);
        $authUrl = "{$parsed['scheme']}://{$parsed['host']}{$parsed['path']}";
        $composerPath = base_path('composer.json');
        $composer = json_decode(file_get_contents($composerPath), true);

        $alreadyExists = collect($composer['repositories'] ?? [])->contains(fn($r) => $r['url'] === $repo);
        if (!$alreadyExists) {
            $composer['repositories'][] = ['type' => 'vcs', 'url' => $authUrl];
            file_put_contents($composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info("Added repository to composer.json");
        }

        // Step 3: Install package
        exec("composer require {$package}:dev-main", $output, $status);
        if ($status !== 0) {
            $this->error("Composer require failed: " . implode("\n", $output));
            return 1;
        }
        $this->info("Package installed: {$package}");

        // Step 4: Publish assets
        foreach (['exam-routes', 'exam-components', 'exam-views', 'exam-migrations', 'exam-config', 'examteacherapi-routes'] as $tag) {
            Artisan::call('vendor:publish', ['--tag' => $tag, '--force' => true]);
            $this->info("Published: {$tag}");
        }

        // Step 5: Update route loader
        $routesPath = base_path('routes/web.php');
        $customRoutes = [
            "if (file_exists(base_path('routes/gexam.php'))) {\n    require base_path('routes/gexam.php');\n}",
            "if (file_exists(base_path('routes/gexamteacherapi.php'))) {\n    require base_path('routes/gexamteacherapi.php');\n}"
        ];

        foreach ($customRoutes as $line) {
            if (!str_contains(file_get_contents($routesPath), trim($line))) {
                file_put_contents($routesPath, "\n{$line}\n", FILE_APPEND);
                $this->info("Appended to routes/web.php");
            }
        }

        // Step 6: Add to app.js
        $appJsPath = resource_path('js/app.js');
        if (!str_contains(file_get_contents($appJsPath), "require('./gexam')")) {
            file_put_contents($appJsPath, file_get_contents($appJsPath) . "\nrequire('./gexam');\n");
            $this->info("Updated app.js");
        }

        // Step 7: NPM install/build
        exec('npm install', $npmOut, $npmStatus);
        exec('npm run dev', $devOut, $devStatus);
        $this->info("NPM build complete");

        // Step 8: Migrate
        Artisan::call('migrate', ['--force' => true]);
        $this->info("Database migrated");

        $this->info("Module installed successfully!");
        return 0;
    }
}
