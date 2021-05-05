FROM webdevops/php-nginx:7.4

LABEL name="erpjp-school" author="carlosocarvalho" email="contato@carlosocarvalho.com.br"

WORKDIR /app/

COPY  . /app/ 


# COPY app.conf /opt/docker/etc/httpd/conf.d/app.conf

COPY docker/php.ini /opt/docker/etc/php/php.ini

# COPY docker/supervisor.conf /opt/docker/etc/supervisor.d/schedule.conf

COPY ./openssl.cnf /etc/ssl/openssl.cnf


RUN apt update && \
    apt install -y xfonts-75dpi xfonts-base gvfs colord glew-utils libvisual-0.4-plugins \
     gstreamer1.0-tools opus-tools qt5-image-formats-plugins qtwayland5 \
     qt5-qmltooling-plugins librsvg2-bin lm-sensors

RUN dpkg -i wkhtmltox_0.12.5-1.stretch_amd64.deb && \
    cp /usr/local/bin/wkhtmltopdf /usr/bin/ && \
    cp /usr/local/bin/wkhtmltoimage /usr/bin/     

RUN touch /app/.env && \
   chmod 777 /app/application/config/license.php && \
   chmod 777 application/config/config.php && \
   mkdir -p -m 777 /app/temp

RUN chmod +x /app/schedule-run.sh   


RUN composer install
