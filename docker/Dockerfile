FROM webdevops/php-nginx:7.4

LABEL name="erpjp-school" author="carlosocarvalho" email="contato@carlosocarvalho.com.br"

WORKDIR /app/

COPY  . /app/ 


# COPY app.conf /opt/docker/etc/httpd/conf.d/app.conf

COPY docker/php.ini /opt/docker/etc/php/php.ini

COPY docker/supervisor.conf /opt/docker/etc/supervisor.d/schedule.conf
RUN touch /app/.env && \
   chmod 777 /app/application/config/license.php


RUN composer install
