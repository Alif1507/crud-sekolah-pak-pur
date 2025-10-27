# Dockerfile
FROM php:8.3-apache

# Ekstensi yang dibutuhkan
RUN docker-php-ext-install pdo pdo_mysql \
 && a2enmod rewrite headers

# Set DocumentRoot ke /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}/>!g' /etc/apache2/apache2.conf \
 && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

# Copy source
WORKDIR /var/www/html
COPY . /var/www/html

# (opsional) permission
RUN chown -R www-data:www-data /var/www/html
