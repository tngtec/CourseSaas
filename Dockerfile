FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    default-mysql-server \
    default-mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/

EXPOSE 80

CMD service mysql start && \
    mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY ''; FLUSH PRIVILEGES;" && \
    mysql -e "CREATE DATABASE IF NOT EXISTS base1;" && \
    mysql base1 < /var/www/html/database.sql && \
    apache2-foreground