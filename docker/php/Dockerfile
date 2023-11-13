FROM php:8.1.0-fpm-alpine

# Устанавливаем необходимые зависимости и расширения
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Копируем файлы проекта в образ
COPY . /var/www/html

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем зависимости проекта
RUN composer install --no-interaction --optimize-autoloader


