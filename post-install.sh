#!/bin/sh
git pull
composer  install --no-dev --no-interaction --prefer-dist --optimize-autoloader

if [ -f artisan ]; then
    php artisan migrate --force
    php artisan queue:restart
    npm i
    npm run prod
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi
