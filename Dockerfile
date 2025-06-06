# Usa un'immagine base PHP con estensioni comuni
FROM php:8.2-fpm

# Installa dipendenze di sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    git \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath



# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installa Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Imposta la directory di lavoro
WORKDIR /var/www

# Copia i file
COPY . .


# Installa dipendenze PHP e JS
RUN composer install --no-dev --optimize-autoloader \
    && npm install && npm run build

# Espone la porta (es. Laravel Octane usa 8000 o 8080)
EXPOSE 8000

RUN ls -la public && ls -la storage/app/public

# Comando di avvio (modifica in base al server usato: octane, artisan serve, ecc.)
CMD rm -rf public/storage && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=9000

