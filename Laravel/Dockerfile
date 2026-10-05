# 1. Imagen base oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# 2. Instalar dependencias del sistema y extensiones para Laravel, MySQL y Dompdf
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip

# 3. Copiar Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Habilitar mod_rewrite de Apache para las rutas amigables de Laravel
RUN a2enmod rewrite

# 5. Configurar Apache para que apunte a la carpeta public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Establecer el directorio de trabajo dentro del servidor
WORKDIR /var/www/html

# 7. Copiar todos los archivos del proyecto al servidor cloud
COPY . .

# 8. Instalar dependencias de producción de Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 9. Asignar permisos de escritura a las carpetas de caché y fotos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Exponer el puerto web 80
EXPOSE 80

# 11. Arrancar optimizaciones de Laravel y levantar Apache
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link && \
    apache2-foreground
