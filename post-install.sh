#!/bin/sh
git pull
if [ -f .vendor/bin/composer];then
  ./vendor/bin/composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
else
  composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
fi
if [ -f artisan ]; then
    php artisan migrate --force
    php artisan queue:restart
    npm i
    npm run prod
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi
