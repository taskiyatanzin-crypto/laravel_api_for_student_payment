# ---------- Stage 1: Backend ----------
FROM php:8.2-cli AS backend

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# 👉 env example copy (important)
RUN cp .env.example .env || true

# 👉 install ছাড়া scripts run না (safe)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts


# ---------- Stage 2: Frontend ----------
FROM node:22 AS frontend

WORKDIR /app

COPY --from=backend /var/www .

RUN npm install
RUN npm run build


# ---------- Stage 3: Production ----------
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www

COPY --from=backend /var/www .
COPY --from=frontend /app/public/build ./public/build

# 👉 permissions fix
RUN chmod -R 777 storage bootstrap/cache || true

EXPOSE 10000

# 👉 startup script (safe way)
CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
