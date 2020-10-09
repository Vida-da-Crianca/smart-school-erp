FROM webdevops/php-nginx:5.6

LABEL name="erpjp-school" author="carlosocarvalho" email="contato@carlosocarvalho.com.br"

WORKDIR /app/

COPY  . /app/ 


# COPY app.conf /opt/docker/etc/httpd/conf.d/app.conf

COPY docker/php.ini /opt/docker/etc/php/php.ini

# COPY docker/supervisor.conf /opt/docker/etc/supervisor.d/app.conf
RUN touch /app/.env

RUN composer install
