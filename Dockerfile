# STEP 1: base image with PHP, Composer, and Node
FROM node:18 as nodebuilder

# Install PHP and dependencies
RUN apt-get update && apt-get install -y \
    php-cli php-mbstring php-xml php-bcmath php-curl php-zip php-mysql \
    unzip curl git apache2 libapache2-mod-php php-pdo

# Set working directory
WORKDIR /app

# Copy only package and composer files
COPY package*.json ./
COPY composer.* ./

# Install Node dependencies
RUN npm install

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copy full project and install PHP dependencies
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm run build

# Set permissions
RUN chmod -R 755 storage && chmod -R 755 bootstrap/cache

# STEP 2: build final Apache image
FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app from previous image
COPY --from=nodebuilder /app /var/www/html

# Change document root to /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose Railway port
EXPOSE 8080

CMD ["apache2-foreground"]
