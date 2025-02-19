FROM php:8.0-apache

# CONFIGURAÇÃO DE PROXY
# ENV HTTP_PROXY=http://06430396355:Garcia2002%40@10.108.88.4:8080 \
#     http_proxy=http://06430396355:Garcia2002%40@10.108.88.4:8080 \
#     HTTPS_PROXY=http://06430396355:Garcia2002%40@10.108.88.4:8080 \
#     https_proxy=http://06430396355:Garcia2002%40@10.108.88.4:8080 \
#     NO_PROXY=10.*;*.intraer \
#     no_proxy=10.*;*.intraer

RUN apt-get update && apt-get install -y \ 
    libzip-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip

# Configurar o Apache para usar a página de erro personalizada
RUN echo 'ErrorDocument 404 /errors/404.html' >> /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html