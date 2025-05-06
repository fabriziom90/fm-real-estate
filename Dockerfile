FROM php:8.2-cli

# Installa estensioni richieste
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libpq-dev \
    libmcrypt-dev

# Installa estensione swoole
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Installa estensioni PHP comuni
RUN docker-php-ext-install pdo pdo_mysql zip

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia file e installa dipendenze
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Espone la porta usata da Octane
EXPOSE 8000

# Avvia Octane (Swoole)
CMD php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
