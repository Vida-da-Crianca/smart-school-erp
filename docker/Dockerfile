FROM webdevops/php-nginx:7.4

LABEL name="erpjp-school" author="carlosocarvalho" email="contato@carlosocarvalho.com.br"

WORKDIR /app/

COPY  . /app/ 


# COPY app.conf /opt/docker/etc/httpd/conf.d/app.conf

COPY docker/php.ini /opt/docker/etc/php/php.ini

# COPY docker/supervisor.conf /opt/docker/etc/supervisor.d/schedule.conf

COPY ./openssl.cnf /etc/ssl/openssl.cnf

RUN touch /app/.env && \
   chmod 777 /app/application/config/license.php && \
   chmod 777 application/config/config.php && \
   mkdir -p -m 777 /app/temp

RUN chmod +x /app/schedule-run.sh   


RUN composer install
