FROM php:8.0.8-apache-buster

RUN apt-get update
apt-get install -y zlib1g-dev libzip-dev libonig-dev
RUN apt-get install -y wget unzip

RUN cd /root
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN cd /var/www/html

WORKDIR /var/www/html

RUN composer require google/apiclient

RUN chmod 755 -R /var/www/html

COPY tls/ca.crt /etc/apache2/ssl/ca.crt
COPY tls/ca.crt /etc/apache2/ssl/cloudflare.crt
COPY tls/ca.key /etc/apache2/ssl/ca.key
COPY conf/YOUR.DOMAIN.conf /etc/apache2/sites-enabled/YOUR.DOMAIN.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql zip mbstring

RUN a2enmod rewrite
RUN a2enmod ssl
RUN service apache2 restart

EXPOSE 443
EXPOSE 80


