# Use the official PHP 8.4 image as the base
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
git \
curl \
libpq-dev \
libpng-dev \
libonig-dev \
libxml2-dev \
zip \
unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN set -ex \ && apk --no-cache add postgresql-dev nodejs yarn npm\ && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www