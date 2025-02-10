# Use the official PHP 8.4 image as the base
FROM php:8.4-fpm

# Use the existing 'ubuntu' user instead of creating a new one
USER ubuntu

# Ensure the ubuntu user is added to the correct groups (www-data and root)
RUN usermod -aG www-data,root ubuntu

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
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create the .composer directory and set proper ownership
RUN mkdir -p /home/ubuntu/.composer && \
    chown -R ubuntu:ubuntu /home/ubuntu

# Install PHP extensions and other setup steps
# Ensure that the user is able to run commands as the correct user
RUN docker-php-ext-install pdo_pgsql pgsql

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql nodejs npm

# Set working directory
WORKDIR /var/www

USER ubuntu