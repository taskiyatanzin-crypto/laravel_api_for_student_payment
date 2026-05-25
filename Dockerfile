FROM php:8.2-cli

# system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev

# PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql

# verify extension
RUN php -m | grep -E "mysql|pgsql"

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

RUN php artisan config:cache || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
