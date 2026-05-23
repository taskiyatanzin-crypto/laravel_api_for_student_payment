FROM php:8.2-cli

# system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev

# PHP extensions (PostgreSQL support)
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# verify extension (debug only)
RUN php -m | grep pgsql

# working directory
WORKDIR /var/www

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . /var/www

# install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache safety (BEST PRACTICE ORDER)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# rebuild cache (IMPORTANT)
RUN php artisan config:cache

# expose port (Render requirement)
EXPOSE 10000

# start server
CMD php artisan serve --host=0.0.0.0 --port=10000
