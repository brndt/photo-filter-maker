FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	librabbitmq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo pdo_mysql sockets bcmath -j$(nproc) gd

RUN apt -y install curl git unzip \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer

RUN pecl install amqp && docker-php-ext-enable amqp
ENTRYPOINT ["bash","/var/www/scripts/message-consumer.sh"]
