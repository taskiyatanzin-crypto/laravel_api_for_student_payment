FROM php:8.2-cli

# system deps
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpq-dev libonig-dev libxml2-dev nodejs npm

# php extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# install backend deps
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# frontend build (Vue/Inertia)
RUN npm install
RUN npm run build

# permissions
RUN chmod -R 775 storage bootstrap/cache || true

# Render port binding (MOST IMPORTANT)
CMD php -S 0.0.0.0:$PORT -t public
