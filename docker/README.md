# Container deployment

This directory documents the self-contained Docker setup that builds the Laravel application, compiles the front-end assets, and orchestrates the runtime services declared in `docker-compose.yml`.

## Architecture overview

- **App container** – Built by the multi-stage `Dockerfile` to install Composer dependencies, compile the Laravel Mix assets with Node.js, and run the framework under Apache and PHP 8.2. Apache's document root points to `public/` and the required PHP extensions are compiled in for production use.
- **MySQL database (`db`)** – Provides the default relational store with a persistent `mysql_data` volume and a health-check so the application waits for readiness.
- **Redis cache (`redis`)** – Supplies cache, session, and queue backends and persists data in the `redis_data` volume.
- **Mailhog (`mailhog`)** – Captures outbound mail for local testing with a web UI exposed on port 8025.
- **Persistent storage** – The `storage_data` volume preserves the Laravel `storage/` directory across container rebuilds.
- **Compose bundles** – `docker-compose.dependencies.yml` isolates the infrastructure services so they can run independently, while `docker-compose.yml` focuses on the PHP application and extends those shared definitions.

## Prerequisites

- Docker Engine 24+ and Docker Compose v2.17+ installed locally.
- At least 4GB of RAM for the initial build (Composer install + asset compilation).
- Ports 8000 and 8025 available on the host (override with `APP_PORT` and `MAILHOG_PORT`).

## Quick start

1. **(Optional) Provide environment overrides** – Edit the root `.env` file when you need to override database credentials, host ports, or third-party API keys. The container copies `.env.example` automatically when no `.env` is present.
2. **Start the shared services** – `docker compose -f docker-compose.dependencies.yml up -d` boots MySQL, Redis, and Mailhog on their own. This step is optional because the application compose file extends the same definitions and will start them when needed.
3. **Build and launch the PHP application** – `docker compose up -d --build app` compiles Composer and npm dependencies without prompting for user input and brings Apache online. The first build can take a few minutes.
4. **Tail logs** – `docker compose logs -f app` shows the bootstrap sequence (key generation, migrations, cache warming).
5. **Access the services** – Visit `http://localhost:8000` for the application and `http://localhost:8025` for Mailhog. Use `docker compose down` to stop everything when finished.

## Runtime automation

The `app-entrypoint` script prepares the container before Apache starts:

- Copies `.env.example` to `.env` on first boot so Artisan commands have configuration defaults.
- Generates `APP_KEY` once if none is provided through the environment.
- Creates and fixes permissions on the framework cache directories inside the `storage/` volume.
- Waits for the database service to become reachable (unless `WAIT_FOR_DB=false`).
- Runs `php artisan migrate --force` automatically (`RUN_MIGRATIONS=false` skips it) and seeds the database when `RUN_SEEDERS=true`.
- Refreshes cached framework metadata and re-creates the `public/storage` symlink.

These behaviours make the container reproducible out of the box while remaining configurable via environment variables.

## Environment variables

Docker Compose reads the root `.env` file for variable substitution and passes many of those values to the Laravel container. Values omitted here fall back to the defaults from `.env.example`.

### Infrastructure overrides (Docker-only)

| Variable | Default | Description |
| --- | --- | --- |
| `APP_PORT` | `8000` | Host port that forwards to Apache port 80 inside the `app` container. |
| `MAILHOG_PORT` | `8025` | Host port that exposes the Mailhog web UI. |
| `DB_ROOT_PASSWORD` | `rootpassword` | Root password applied to the MySQL container. |
| `RUN_MIGRATIONS` | `true` | Toggle automatic `php artisan migrate --force` on container start. |
| `RUN_SEEDERS` | `false` | When set to `true`, runs `php artisan db:seed --force` after migrations. |
| `WAIT_FOR_DB` | `true` | Skip the database readiness probe by setting this to `false`. |

### Core application settings

| Variable | Default | Purpose |
| --- | --- | --- |
| `APP_NAME` | `Gegok12` | Application display name used in notifications and mails. |
| `APP_ENV` | `local` | Laravel environment name (e.g., `local`, `staging`, `production`). |
| `APP_KEY` | _(empty)_ | Encryption key; auto-generated when blank. |
| `APP_DEBUG` | `true` | Enables verbose error output when `true`. |
| `APP_URL` | `http://localhost` | Base URL used for URL generation and asset links. |
| `LOG_CHANNEL` | `daily` | Log channel/driver to use for framework logs. |
| `TIMEZONE` | `Asia/Kolkata` | Default application timezone. |
| `DEBUG_BAR` | `false` | Toggles the Laravel Debugbar package. |
| `CACHE_TIME` | `8400` | Default cache TTL (seconds) for custom caching logic. |
| `SNOOZE_TIME` | `600` | Default reminder snooze duration (seconds). |

### Storage, cache, and queues

| Variable | Default | Purpose |
| --- | --- | --- |
| `FILESYSTEM_DRIVER` | `'s3'` | Default filesystem disk (Docker overrides this to `local`). |
| `FILESYSTEM_CLOUD` | `s3` | Cloud filesystem disk name. |
| `BROADCAST_DRIVER` | `log` | Broadcast driver to use for realtime events. |
| `CACHE_DRIVER` | `file` | Cache backend (`file`, `redis`, etc.). |
| `SESSION_DRIVER` | `file` | Session storage backend. |
| `SESSION_LIFETIME` | `120` | Session lifetime in minutes. |
| `QUEUE_DRIVER` | `database` | Queue connection driver. |
| `SCOUT_QUEUE` | `true` | Queue Scout indexing jobs instead of running synchronously. |

### Database and Redis

| Variable | Default | Purpose |
| --- | --- | --- |
| `DB_CONNECTION` | `mysql` | Primary database driver. |
| `DB_HOST` | `127.0.0.1` | Database hostname (set to `db` inside Docker). |
| `DB_PORT` | `3306` | Database port. |
| `DB_DATABASE` | `homestead` | Database schema name. |
| `DB_USERNAME` | `homestead` | Database user. |
| `DB_PASSWORD` | `secret` | Database password. |
| `REDIS_HOST` | `127.0.0.1` | Redis host (set to `redis` inside Docker). |
| `REDIS_PASSWORD` | `null` | Redis password when authentication is enabled. |
| `REDIS_PORT` | `6379` | Redis port. |

### Mail and reminders

| Variable | Default | Purpose |
| --- | --- | --- |
| `MAIL_DRIVER` | `smtp` | Mail transport driver. |
| `MAIL_HOST` | `smtp.mailtrap.io` | SMTP server hostname. |
| `MAIL_PORT` | `2525` | SMTP port. |
| `MAIL_USERNAME` | `null` | SMTP username. |
| `MAIL_PASSWORD` | `null` | SMTP password. |
| `MAIL_ENCRYPTION` | `null` | SMTP encryption protocol (`tls`, `ssl`, etc.). |
| `MAIL_FROM_ADDRESS` | _(empty)_ | Default “from” email address. |
| `MAIL_STATUS` | `on` | Toggle outbound email dispatching. |
| `REMINDER` | `mail` | Default reminder channel. |
| `REMINDER_API_KEY` | _(empty)_ | API key for the configured reminder service. |
| `REMINDER_SENDER_ID` | `""` | Sender ID for SMS/email reminders. |
| `REMINDER_ROUTE_NO` | _(empty)_ | Routing number for the reminder provider. |
| `SMS_GATEWAY` | `MSG91` | Active SMS provider integration. |
| `SMS_STATUS` | `off` | Toggle SMS dispatching. |

The bundled Docker Compose configuration points `MAIL_HOST=mailhog` and `MAIL_PORT=1025` to route messages into the local Mailhog inbox; change these values when connecting to a real SMTP relay.

### Realtime and front-end integrations

| Variable | Default | Purpose |
| --- | --- | --- |
| `PUSHER_APP_ID` | _(empty)_ | Pusher application ID. |
| `PUSHER_APP_KEY` | _(empty)_ | Pusher key. |
| `PUSHER_APP_SECRET` | _(empty)_ | Pusher secret. |
| `PUSHER_APP_CLUSTER` | `mt1` | Pusher cluster. |
| `MIX_PUSHER_APP_KEY` | `${PUSHER_APP_KEY}` | Front-end copy of the Pusher key. |
| `MIX_PUSHER_APP_CLUSTER` | `${PUSHER_APP_CLUSTER}` | Front-end copy of the Pusher cluster. |

### Cloud storage, captcha, and analytics

| Variable | Default | Purpose |
| --- | --- | --- |
| `AWS_KEY` | _(empty)_ | AWS access key for S3 storage. |
| `AWS_SECRET` | _(empty)_ | AWS secret key. |
| `AWS_REGION` | _(empty)_ | AWS region. |
| `AWS_BUCKET` | _(empty)_ | S3 bucket name. |
| `AWS_ENDPOINT` | _(empty)_ | Custom S3-compatible endpoint. |
| `GOOGLE_RECAPTCHA_KEY` | _(empty)_ | Google reCAPTCHA site key. |
| `GOOGLE_RECAPTCHA_SECRET` | _(empty)_ | Google reCAPTCHA secret key. |
| `ALGOLIA_APP_ID` | _(empty)_ | Algolia application ID. |
| `ALGOLIA_SECRET` | _(empty)_ | Algolia admin API key. |

### Telephony, Firebase, and add-ons

| Variable | Default | Purpose |
| --- | --- | --- |
| `TWILIO_SID` | _(empty)_ | Twilio account SID. |
| `TWILIO_TOKEN` | _(empty)_ | Twilio auth token. |
| `TWILIO_KEY` | _(empty)_ | Twilio API key. |
| `TWILIO_SECRET` | _(empty)_ | Twilio API secret. |
| `FIREBASE_CREDENTIALS` | `''` | Path or JSON blob for Firebase admin credentials. |
| `TEACHER_FIREBASE_CREDENTIALS` | `''` | Firebase credentials used for teacher notifications. |
| `ADDON_API_URL` | _(empty)_ | Base URL for addon integrations. |

## Data management

- The MySQL data directory persists in the `mysql_data` volume; remove it with `docker volume rm ems_mysql_data` (the prefix matches your project directory name).
- Uploaded files and generated reports live under the `storage_data` volume. Back this up before destroying the environment.
- Run one-off Artisan commands inside the container, e.g. `docker compose exec app php artisan queue:work`.

## Troubleshooting

- If the build fails during `npm ci`, make sure the host has enough memory; rerun the build afterwards.
- Set `APP_DEBUG=false` in production-like scenarios to disable verbose error output.
- Disable automatic migrations when pointing the container at an existing database by exporting `RUN_MIGRATIONS=false`.
