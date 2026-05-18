FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpq-dev libonig-dev libxml2-dev \
    nodejs npm

# PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install backend dependencies
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# Install + build frontend (Vue / Vite)
RUN npm install
RUN npm run build

# Fix permissions (important for Laravel)
RUN chmod -R 775 storage bootstrap/cache || true

# Render port binding (VERY IMPORTANT)
EXPOSE $PORT

# FINAL RUN COMMAND (IMPORTANT FIX)
CMD php -S 0.0.0.0:$PORT -t public
