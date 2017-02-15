FROM debian:8.7
MAINTAINER "derek@grindaga.com"

RUN apt-get update
RUN apt-get install -y apt-utils apt-transport-https lsb-release ca-certificates wget
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
RUN apt-get install -y apache2 ant curl git
RUN apt-get update
RUN apt-get install -y php7.1 php7.1-common php7.1-cli php7.1-mysql php7.1-mbstring php7.1-mcrypt php7.1-xml php-xdebug php7.1-curl
RUN curl -o installer.php https://getcomposer.org/installer
RUN php -f installer.php
RUN mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer
RUN a2enmod rewrite
RUN a2enmod headers

COPY ./httpd.conf /etc/apache2/apache2.conf

EXPOSE  80
