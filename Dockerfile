FROM php:8.2-cli

# system packages
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm

# PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# copy project
COPY . .

# install PHP dependencies
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# install JS + build Vite (VERY IMPORTANT)
RUN npm install
RUN npm run build

# permissions
RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 10000

# start server
CMD php artisan serve --host=0.0.0.0 --port=10000
