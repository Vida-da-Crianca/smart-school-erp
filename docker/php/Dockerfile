FROM php:7.4.2-fpm-buster

RUN apt-get update && apt-get install -y \
        freetds-bin \
        freetds-dev \
        freetds-common \
        libct4 \
        libsybdb5 \
        tdsodbc \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libldap2-dev \
        libpq-dev \
        zlib1g-dev \
        libc-client-dev \
        libzip-dev \
        zip \
        cron

RUN ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/
RUN ln -s /usr/lib/x86_64-linux-gnu/libpq-fe.h /usr/lib/

RUN docker-php-ext-install pdo pdo_mysql pdo_dblib pdo_pgsql gd zip

RUN apt-get install unixodbc unixodbc-dev -y \
 && docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
 && docker-php-ext-install pdo_odbc

# COPY ./freetds.conf /etc/freetds/freetds.conf
# COPY ./odbc.ini /etc/odbc.ini
# COPY ./odbcinst.ini /etc/odbcinst.ini
# COPY ./php.ini /usr/local/etc/php

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir /var/www/html/files && chown -R www-data:www-data /var/www/html/files && chmod -R 755 /var/www/html/files
RUN mkdir /var/www/html/exports && chown -R www-data:www-data /var/www/html/exports && chmod -R 755 /var/www/html/exports
RUN mkdir /var/www/html/scripts && chown -R www-data:www-data /var/www/html/scripts && chmod -R 755 /var/www/html/scripts

# copying cronjobs, a file I created with a test cronjob to /etc
# COPY ./docker/cronjobs /etc
# using the cronjobs file I created as the crontab


# RUN crontab /etc/cronjobs

CMD cron start
# && tail -f /var/log/cron.log

EXPOSE 9000