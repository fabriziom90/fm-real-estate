FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
    zip libssl-dev pkg-config libmcrypt-dev libreadline-dev \
    && docker-php-ext-install pdo pdo_mysql zip pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install Swoole for Octane
RUN pecl install swoole && docker-php-ext-enable swoole

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Ensure correct permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose the Octane port
EXPOSE 8000

# Start Laravel Octane with Swoole
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
