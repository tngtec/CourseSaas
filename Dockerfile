FROM php:8.1-apache

# Instalar extensiones necesarias para la base de datos
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar el código al servidor web
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80