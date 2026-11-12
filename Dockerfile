FROM php:5.6-apache

# Install MySQL and PDO extensions
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Allow .htaccess override
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Working directory
WORKDIR /var/www/html/seppro

# Database host build argument (default: seppro_db)
ARG DB_HOST=seppro_db

# PHP settings: error reporting, output buffering, TCP defaults, session configuration
RUN echo "display_errors = Off" >> /usr/local/etc/php/php.ini \
    && echo "error_reporting = 0" >> /usr/local/etc/php/php.ini \
    && echo "output_buffering = On" >> /usr/local/etc/php/php.ini \
    && echo "mysql.default_host = ${DB_HOST}" >> /usr/local/etc/php/php.ini \
    && echo "mysqli.default_host = ${DB_HOST}" >> /usr/local/etc/php/php.ini \
    && echo "pdo_mysql.default_socket=" >> /usr/local/etc/php/php.ini \
    && echo "mysql.default_socket=" >> /usr/local/etc/php/php.ini \
    && echo "session.cookie_secure = 0" >> /usr/local/etc/php/php.ini \
    && echo "session.cookie_httponly = 1" >> /usr/local/etc/php/php.ini \
    && echo "session.cookie_samesite = Lax" >> /usr/local/etc/php/php.ini \
    && echo "session.save_path = /tmp" >> /usr/local/etc/php/php.ini

EXPOSE 80

