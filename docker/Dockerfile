FROM webdevops/php-nginx:5.6

LABEL name="erpjp-school" author="carlosocarvalho" email="contato@carlosocarvalho.com.br"

WORKDIR /app/

COPY  . /app/ 

RUN chmod 777 -R /app/js
RUN chmod 777 -R /app/css

RUN chmod 777 -R /app/admin/css
RUN chmod 777 -R /app/admin/js

RUN chmod 777 -R /app/vendedor/css
RUN chmod 777 -R /app/vendedor/js

COPY app.conf /opt/docker/etc/httpd/conf.d/app.conf

COPY docker/php.ini /opt/docker/etc/php/php.ini

# COPY docker/supervisor.conf /opt/docker/etc/supervisor.d/app.conf

RUN composer install