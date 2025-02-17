# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libonig-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verificar que Composer está instalado
RUN composer --version

# Habilitar mod_rewrite en Apache (opcional)
RUN a2enmod rewrite

# Copiar el código fuente de la aplicación (si es necesario)
COPY . /var/www/html

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto 80
EXPOSE 80

# Instalar dependencias de Composer si existe un composer.json
RUN if [ -f "composer.json" ]; then composer install --no-dev --optimize-autoloader; fi