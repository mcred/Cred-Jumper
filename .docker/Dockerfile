FROM debian:8.7
MAINTAINER "derek@grindaga.com"

RUN apt-get update
RUN apt-get install -y apt-utils apt-transport-https lsb-release ca-certificates wget
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
RUN apt-get install -y apache2
RUN apt-get update
RUN apt-get install -y php7.1 php7.1-common php7.1-cli php7.1-mysql php7.1-mbstring php7.1-mcrypt

COPY ./httpd.conf /etc/httpd/conf/
COPY start-httpd.sh /

EXPOSE  80
