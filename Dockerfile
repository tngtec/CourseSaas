FROM php:8.1-apache

# Instalar MariaDB server, client y extensiones de PHP
RUN apt-get update && apt-get install -y \
    mariadb-server \
    mariadb-client \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copiar los archivos del proyecto al servidor web
COPY . /var/www/html/

EXPOSE 80

# Inicializar MariaDB correctamente e importar la base de datos base1
CMD mysqld_safe --skip-grant-tables & \
    sleep 5 && \
    mysql -e "CREATE DATABASE IF NOT EXISTS base1;" && \
    mysql base1 < /var/www/html/database.sql && \
    apache2-foreground