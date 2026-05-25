# ---------- Stage 1: Frontend Build ----------
FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ---------- Stage 2: PHP / Laravel ----------
FROM php:8.2-cli

# system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /var/www

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project
COPY . .

# copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# install php deps
RUN composer install --no-dev --optimize-autoloader

# permissions
RUN chmod -R 775 storage bootstrap/cache || true

# clear cache safely
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# build caches
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Render dynamic port support
EXPOSE 10000

CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
