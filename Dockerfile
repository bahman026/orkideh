FROM php:8.3-fpm

ARG gid
ARG uid

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y curl
RUN apt-get install -y libpng-dev
RUN apt-get install -y libonig-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y zip
RUN apt-get install -y unzip
RUN apt-get install -y libzip-dev
RUN apt-get install -y libwebp-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libxpm-dev
RUN apt-get install -y libfreetype6-dev




RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd \
    --enable-gd \
    --with-webp=\usr\include/ \
    --with-jpeg=/usr/include/ \
    --with-xpm=/ussr/include/ \
    --with-freetype=/usr/include/
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Create system user to run Composer and Artisan Commands
RUN usermod -u $uid www-data
RUN groupmod -g $gid www-data

COPY . /var/www/html
# Set working directory
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www

USER www-data

ENTRYPOINT ["./run.sh"]


