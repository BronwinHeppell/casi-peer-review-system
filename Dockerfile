# Use the official PHP 8.4 image as the base
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    zip \
    git \
    unzip \
    libicu-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql xml intl bcmath opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy the application files into the container
COPY . /var/www/html

# Set the proper permissions for the app directory
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

# Install application dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Wait for the PostgreSQL database to be ready and run Laravel tasks
RUN apt-get install -y postgresql-client \
    && until pg_isready -h pgsql -U "$DB_USERNAME"; do \
    echo "Waiting for PostgreSQL to be ready..."; \
    sleep 2; \
    done && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose the application port (80 by default)
EXPOSE 80

# Start PHP-FPM
CMD ["php-fpm"]

# Use the appropriate user for the PHP process
USER www-data
