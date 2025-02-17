# Usar la imagen base de PHP con Apache
FROM php:7.4-apache

# Instalar dependencias necesarias (por ejemplo, MySQL client)
RUN apt-get update && apt-get install -y mariadb-client

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar el contenido del proyecto al contenedor
COPY . /var/www/html

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configurar la base de datos con Mariadb
RUN mkdir -p /docker-entrypoint-initdb.d
COPY worms_tournament.sql /docker-entrypoint-initdb.d/

# Exponer los puertos
EXPOSE 80 3306
