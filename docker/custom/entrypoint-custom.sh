#!/bin/bash

######### NGINX ########
echo "INICIANDO NGINX"
nginx

######### PERMISSÕES DE SESSÕES #########

REDIS_SESSION_DIR=${REDIS_SESSION_DIR:-/var/www/var/sessions}

# Verificar e garantir que o diretório de sessões existe e tem as permissões corretas
if [ ! -e $REDIS_SESSION_DIR ]; then
    mkdir -p $REDIS_SESSION_DIR
fi

# Ajuste de permissões para garantir que o usuário www-data possa ler e escrever nesse diretório
chown -R www-data:www-data $REDIS_SESSION_DIR
chmod -R 770 $REDIS_SESSION_DIR

######### SMTP ##########

RECIPIENT_RESTRICTIONS=static:OK

export SMTP_LOGIN SMTP_PASSWORD RECIPIENT_RESTRICTIONS
export SMTP_HOST=${SMTP_HOST:-"smtp.gmail.com"}
export SMTP_PORT=${SMTP_PORT:-"587"}
export USE_TLS=${USE_TLS:-"yes"}
export TLS_VERIFY=${TLS_VERIFY:-"may"}

# Render template and write postfix main config
cat <<- EOF > /etc/postfix/main.cf
#
# Just the bare minimal
#

# write logs to stdout
maillog_file = /var/log/mail.log
#maillog_file = /dev/stdout

# network bindings
inet_interfaces = all
inet_protocols = ipv4

# general params
compatibility_level = 2
myhostname = $HOSTNAME
mynetworks = 127.0.0.0/8 [::1]/128
relayhost = [$SMTP_HOST]:$SMTP_PORT

# smtp-out params
smtp_sasl_auth_enable = yes
smtp_sasl_password_maps = static:$SMTP_LOGIN:$SMTP_PASSWORD
smtp_sasl_security_options = noanonymous
smtp_tls_CAfile = /etc/ssl/certs/ca-certificates.crt
smtp_tls_security_level = $TLS_VERIFY
smtp_tls_session_cache_database = btree:\$data_directory/smtp_scache
smtp_use_tls = $USE_TLS

# RCPT TO restrictions
smtpd_recipient_restrictions = check_recipient_access $RECIPIENT_RESTRICTIONS, reject

# some tweaks
biff = no
delay_warning_time = 1h
mailbox_size_limit = 0
readme_directory = no
recipient_delimiter = +
smtputf8_enable = no
EOF

# Generate default alias DB
newaliases

# Launch
echo "INICIANDO SMTP -> [$SMTP_HOST]:$SMTP_PORT"
rm -f /var/spool/postfix/pid/*.pid
postfix -c /etc/postfix start
tail -F /var/log/mail.log &
