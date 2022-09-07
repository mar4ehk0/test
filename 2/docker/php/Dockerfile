FROM php:7.4-fpm

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
  && apt-get install -y libcurl4-openssl-dev libssl-dev libpq-dev zip unzip git libssl-dev \
  && docker-php-ext-install sockets bcmath pdo \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer