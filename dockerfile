FROM php:7.4-apache

ENV NAME_APP RestfulAPI

COPY . /usr/src/${NAME_APP}
WORKDIR /usr/src/${NAME_APP}

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'c5b9b6d368201a9db6f74e2611495f369991b72d9c8cbd3ffbc63edff210eb73d46ffbfce88669ad33695ef77dc76976') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN apt-get update
#RUN apt-get install zip unzip -qy
RUN apt-get install -y openssl zip unzip git

RUN docker-php-ext-install pdo pdo_mysql mbstring

RUN composer install
CMD [ "php", "artisan serve" ]