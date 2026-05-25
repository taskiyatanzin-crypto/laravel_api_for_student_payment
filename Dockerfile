# ---------- Stage 1: Base App ----------
FROM php:8.2-cli AS backend

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /var/www

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy everything first
COPY . .

# install php deps
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# ---------- Stage 2: Frontend ----------
FROM node:22 AS frontend

WORKDIR /app

# copy app including vendor/
COPY --from=backend /var/www ./

# install node deps
RUN npm install

# build vite
RUN npm run build

# ---------- Stage 3: Production ----------
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy backend
COPY --from=backend /var/www ./

# copy built assets
COPY --from=frontend /app/public/build ./public/build

# permissions
RUN chmod -R 775 storage bootstrap/cache || true

# clear/cache safely
RUN php artisan optimize:clear || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 10000

CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
