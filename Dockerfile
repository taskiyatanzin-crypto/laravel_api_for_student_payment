FROM php:8.2-cli

# system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev

# PHP extensions (Postgres support)
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# verify (optional debug)
RUN php -m | grep pgsql

# working directory
WORKDIR /var/www

# copy composer first (better cache)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . /var/www

# install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimization (safe order)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan config:cache || true

# expose port (Render uses 10000)
EXPOSE 10000

# start server
CMD php artisan serve --host=0.0.0.0 --port=10000
