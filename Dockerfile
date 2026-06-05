FROM php:8.2-cli AS backend

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


FROM node:22 AS frontend

WORKDIR /app

COPY --from=backend /var/www .

RUN npm install
RUN npm run build


FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=backend /var/www .
COPY --from=frontend /app/public/build ./public/build

RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 10000

CMD php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
