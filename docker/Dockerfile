FROM hacklab/mapasculturais:7.3.55

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

# Ajustes de permissão
RUN sed -i '/exec/i chown www-data:www-data /var/www/html -R' /entrypoint.sh

# Copiando logo
COPY img/logo-mapas.png /var/www/src/themes/BaseV2/assets/img/logo-mapas.png

# Instalando smtp-relay
COPY docker/custom/entrypoint-custom.sh /tmp/
RUN chmod +x /tmp/entrypoint-custom.sh && \
    sed -i '/exec/i /tmp/entrypoint-custom.sh' /entrypoint.sh && \
    apt update && \
    echo "postfix postfix/mailname string localdomain" | debconf-set-selections && \
    echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections && \
    apt-get install postfix mailutils libsasl2-2 ca-certificates libsasl2-modules -y && \
    sed -i 's/    y    /    n    /g' /etc/postfix/master.cf
