<?php

use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FileTest extends DuskTestCase
{
    public function setUp() :void
    {
        //var_dump(env('DB_DATABASE'));
        parent::setUp();
        $this->runFreshMigrationAndSeed();
    }

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function AdminLogin()
    {
        $this->browse(function ($browser) {
            
            $testuser = User::find(2);

            $browser->visit('/login')
                    ->type('#email', $testuser->email)
                    ->type('#password', 'password')
                    ->pause(2000)
                    ->press('#login')          
                    ->assertPathIs('/admin/dashboard');         
        });
    }

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function AddFileSuccess()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->visit('/admin/files')
                    ->pause(2000)
                    ->type('#name','File')
                    ->type('#description','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
                    ->attach('#file', __DIR__.'/../files/threemb.pdf')
                    ->pause(2000)
                    ->click('#upload')
                    ->pause(5000)
                    ->assertSee('Files Added Successfully')
                    ->pause(1000)
                    ->click('#download')
                    ->pause(5000)
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function FileExtensionError()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->visit('/admin/files')
                    ->pause(2000)
                    ->type('#name','File')
                    ->type('#description','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
                    ->attach('#file', __DIR__.'/../photos/photo.jpg')
                    ->click('#upload')
                    ->pause(5000)
                    ->assertSee('File extension error')
                    ->pause(1000)
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 

    /**
     * A Dusk test example.
     *@test
     * @return void
     */
    public function FileSizeError()
    {
        $this->AdminLogin();

        $this->browse(function ($browser) {
            $testuser = User::find(2);

            $browser->visit('/admin/files')
                    ->pause(2000)
                    ->type('#name','File')
                    ->type('#description','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
                    ->attach('#file', __DIR__.'/../files/tenmb.pdf')
                    ->pause(2000)
                    ->click('#upload')
                    ->pause(5000)
                    ->assertSee('Maximum file size to upload is 8MB')
                    ->pause(1000)
                    ->click('@profile-menu')
                    ->assertSee($testuser->email)
                    ->click('@logout-link')
                    ->assertPathIs('/');
        });          
    } 
}