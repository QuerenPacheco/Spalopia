FROM php:7.4-apache
RUN apt-get update \
    && apt-get install -y \
        git \
        libicu-dev \
        zlib1g-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
    apt-get clean && rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader
COPY . /var/www/html
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html/var
EXPOSE 80
CMD ["apache2-foreground"]