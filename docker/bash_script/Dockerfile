FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	librabbitmq-dev \
	net-tools \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo pdo_mysql sockets bcmath -j$(nproc) gd

RUN pecl install amqp && docker-php-ext-enable amqp

COPY elastic-index-generate.sh /var/www/scripts/

CMD ["bash", "/var/www/scripts/elastic-index-generate.sh"]
