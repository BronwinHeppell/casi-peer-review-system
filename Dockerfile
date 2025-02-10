# Use the official PHP 8.4 image as the base
FROM php:8.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

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

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files (composer.json and composer.lock) to the container
COPY composer.json composer.lock /var/www/

# Run composer install to install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Install frontend dependencies 
WORKDIR /var/www
RUN npm install
RUN npm run build

# Set working directory
WORKDIR /var/www

USER $user