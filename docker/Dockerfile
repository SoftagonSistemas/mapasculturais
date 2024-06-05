FROM hacklab/mapasculturais:7.3.58

# Copiando temas e plugins
COPY themes /var/www/src/themes
COPY plugins /var/www/src/plugins

# Instalando plugin MultipleLocalAuth
ENV PLUGIN_MLA_VERSION=3.0.0
RUN curl -L https://github.com/mapasculturais/plugin-MultipleLocalAuth/archive/refs/tags/v${PLUGIN_MLA_VERSION}.tar.gz | tar -xz -C /var/www/src/plugins/ && \
    mv /var/www/src/plugins/plugin-MultipleLocalAuth-${PLUGIN_MLA_VERSION}/* /var/www/src/plugins/MultipleLocalAuth/ && \
    rm -rf /var/www/src/plugins/plugin-MultipleLocalAuth-${PLUGIN_MLA_VERSION}

# Instalando dependências e construindo projeto
WORKDIR /var/www/src
RUN pnpm install --recursive && pnpm run build

# Configurando diretório de trabalho
WORKDIR /var/www

# Copiando configurações
COPY docker/common/config.d /var/www/config/common.d
COPY docker/production/config.d /var/www/config/config.d

# Copiando logo
COPY img/logo-mapas.png /var/www/src/themes/BaseV2/assets/img/logo-mapas.png

# Instalando smtp-relay
RUN apt update && \
    echo "postfix postfix/mailname string localdomain" | debconf-set-selections && \
    echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections && \
    apt-get install postfix mailutils libsasl2-2 ca-certificates libsasl2-modules wget git neovim -y && \ 
    sed -i 's/    y    /    n    /g' /etc/postfix/master.cf

# Instalando redis
ENV REDIS_VERSION=6.2.14
COPY docker/custom/redis-${REDIS_VERSION}.tar.gz /tmp/
RUN tar -xz -C /usr/src/ -f /tmp/redis-${REDIS_VERSION}.tar.gz && \
    cd /usr/src/redis-${REDIS_VERSION}/ && \
    make install && \
    rm -rf /usr/src/redis-${REDIS_VERSION}

ENV REDIS_CACHE=localhost \
    REDIS_SESSION_PORT=6380 \
    SESSIONS_SAVE_PATH=tcp://localhost:$REDIS_SESSION_PORT

# Instalando nginx
RUN apt install nginx -y &&\
    ln -sf /dev/stderr /var/log/nginx/error.log &&\
    ln -sf /dev/stdout /var/log/nginx/access.log

COPY docker/custom/nginx.conf /etc/nginx/nginx.conf
COPY docker/production/nginx.conf /etc/nginx/conf.d/default.conf

# Copiando arquivos personalizados para módulos
COPY custom/modules/Components/components/main-footer/template.php /var/www/src/modules/Components/components/main-footer/template.php
COPY custom/modules/Home/views/site/index.php /var/www/src/modules/Home/views/site/index.php
COPY custom/modules/Home/components/home-header/template.php /var/www/src/modules/Home/components/home-header/template.php


# Ajustes de permissão e add entrypoint-custom.sh
COPY docker/custom/entrypoint-custom.sh /tmp/entrypoint-custom.sh
RUN sed -i '/^set/a chown www-data:www-data /var/www/html -R' /entrypoint.sh &&\
    sed -i '/^set/a /tmp/entrypoint-custom.sh' /entrypoint.sh &&\
    chmod +x /tmp/entrypoint-custom.sh
