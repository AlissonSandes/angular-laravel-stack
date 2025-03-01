FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
