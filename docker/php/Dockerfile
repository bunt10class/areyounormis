FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libxml2-dev \
    && pecl install redis \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip dom \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

CMD ["php-fpm"]