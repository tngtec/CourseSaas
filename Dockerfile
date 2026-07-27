FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    mariadb-server \
    mariadb-client \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/run/mysqld && chown -R mysql:mysql /var/run/mysqld

COPY . /var/www/html/

EXPOSE 80

CMD mysqld --user=mysql & \
    sleep 5 && \
    mysql -e "CREATE DATABASE IF NOT EXISTS base1;" && \
    mysql base1 < /var/www/html/database.sql && \
    apache2-foreground