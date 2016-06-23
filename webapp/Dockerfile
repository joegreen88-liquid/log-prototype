FROM php:5.6.22-cli

RUN apt-get update && apt-get install -y libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

CMD php -S 0.0.0.0:8109 -t /webapp-data/public /webapp-data/public/index.php