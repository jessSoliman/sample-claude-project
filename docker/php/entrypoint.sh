#!/bin/sh
# Bootstraps a fresh checkout, then runs the container's command.
# Every step is a no-op once done, so restarts stay fast.
set -e

if [ "${APP_BOOTSTRAP:-false}" = "true" ]; then
    [ -f .env ] || cp .env.example .env

    if [ ! -f vendor/autoload.php ] || [ composer.lock -nt vendor/composer/installed.json ]; then
        composer install --no-interaction --prefer-dist
    fi

    grep -q '^APP_KEY=.' .env || php artisan key:generate --force

    [ -f database/database.sqlite ] || touch database/database.sqlite
    php artisan migrate --force

    [ -L public/storage ] || php artisan storage:link
fi

exec "$@"
