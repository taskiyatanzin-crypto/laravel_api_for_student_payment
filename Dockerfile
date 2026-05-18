FROM php:8.2-cli

# system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip npm nodejs

# install php extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# install backend + frontend deps
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
