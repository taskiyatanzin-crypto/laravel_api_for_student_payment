FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libonig-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# 👇 এখানে env + cache fix
RUN cp .env.example .env || true

RUN composer install --no-interaction --prefer-dist

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan config:cache || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
