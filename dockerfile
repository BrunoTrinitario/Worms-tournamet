# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones de PHP y herramientas necesarias
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    curl \
    git \
    libonig-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar mod_rewrite en Apache (opcional)
RUN a2enmod rewrite

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Luego copiar el resto del código
COPY . /var/www/html

# Exponer el puerto 80
EXPOSE 80

CMD ["composer","install"]