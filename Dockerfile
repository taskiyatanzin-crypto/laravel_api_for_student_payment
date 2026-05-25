# ---------- Stage 1: PHP Dependencies ----------
FROM php:8.2-cli AS backend

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /var/www

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy composer files first
COPY composer.json composer.lock ./

# install php dependencies first (important!)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# copy project
COPY . .

# ---------- Stage 2: Frontend Build ----------
FROM node:22 AS frontend

WORKDIR /app

# copy app with vendor folder
COPY --from=backend /var/www ./

# install node deps
COPY package*.json ./
RUN npm install

# build vite
RUN npm run build


# ---------- Stage 3: Final App ----------
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy app
COPY --from=backend /var/www ./

# copy frontend build
COPY --from=frontend /app/public/build ./public/build

# permissions
RUN chmod -R 775 storage bootstrap/cache || true

# laravel cache
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

RUN php artisan config:cache || true

EXPOSE 10000

CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
