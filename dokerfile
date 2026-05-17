FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libonig-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN cp .env.example .env
RUN composer install --no-interaction --prefer-dist
RUN php artisan key:generate

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
