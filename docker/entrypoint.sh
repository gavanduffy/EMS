#!/usr/bin/env bash
set -Eeuo pipefail

APP_DIR="/var/www/html"
cd "${APP_DIR}"

if [ ! -f ".env" ] && [ -f ".env.example" ]; then
  echo "Creating default .env file from template..."
  cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ]; then
  CURRENT_KEY=""
  if [ -f .env ]; then
    CURRENT_KEY=$(grep -E '^APP_KEY=' .env | cut -d '=' -f2- || true)
  fi
  if [ -z "${CURRENT_KEY}" ]; then
    echo "Generating APP_KEY..."
    gosu www-data php artisan key:generate --force --ansi
  fi
fi

readarray -t directories <<'DIRS'
storage/app
storage/framework/cache
storage/framework/sessions
storage/framework/testing
storage/framework/views
storage/logs
bootstrap/cache
DIRS

for dir in "${directories[@]}"; do
  mkdir -p "$dir"
done

chown -R www-data:www-data storage bootstrap/cache

if [ "${WAIT_FOR_DB:-true}" != "false" ] && [ "${DB_CONNECTION:-mysql}" != "sqlite" ]; then
  DB_HOST=${DB_HOST:-db}
  DB_PORT=${DB_PORT:-3306}
  echo "Waiting for database ${DB_CONNECTION:-mysql} at ${DB_HOST}:${DB_PORT}..."
  until php -r "try { \$s = fsockopen('${DB_HOST}', ${DB_PORT}); if (\$s) { fclose(\$s); exit(0);} } catch (\\Throwable \$e) {} exit(1);" >/dev/null 2>&1; do
    sleep 2
  done
fi

if [ "${RUN_MIGRATIONS:-true}" != "false" ]; then
  echo "Running database migrations..."
  gosu www-data php artisan migrate --force --ansi
fi

if [ "${RUN_SEEDERS:-false}" = "true" ]; then
  echo "Seeding database..."
  gosu www-data php artisan db:seed --force --ansi
fi

gosu www-data php artisan storage:link --ansi >/dev/null 2>&1 || true
gosu www-data php artisan package:discover --ansi >/dev/null 2>&1 || true
gosu www-data php artisan filament:upgrade --ansi >/dev/null 2>&1 || true
gosu www-data php artisan optimize:clear --ansi >/dev/null 2>&1 || true
gosu www-data php artisan optimize --ansi >/dev/null 2>&1 || true

exec "$@"
