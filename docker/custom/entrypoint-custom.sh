#!/bin/bash

######### NGINX ########
echo "INICIANDO NGINX"
nginx

######### REDIS CACHE/SESSION #########

REDIS_SESSION_DIR=${REDIS_SESSION_DIR:-/var/www/var/sessions}

[ ! -e $REDIS_SESSION_DIR ] && mkdir $REDIS_SESSION_DIR || chmod o+rx $REDIS_SESSION_DIR -R
[ ! -e /etc/redis ] && mkdir /etc/redis || true

REDIS_CACHE_PORT=${REDIS_CACHE_PORT:-6379}
echo "INICIANDO REDIS-CACHE *:$REDIS_CACHE_PORT"
echo -e "daemonize yes\nprotected-mode no\nport $REDIS_CACHE_PORT\nmaxmemory 1256Mb\nmaxmemory-policy allkeys-lru\nlogfile /tmp/redis-cache.log\npidfile /var/run/redis-cache.pid" > /etc/redis/redis-cache.conf
redis-server /etc/redis/redis-cache.conf
tail -F /tmp/redis-cache.log &

REDIS_SESSION_PORT=${REDIS_SESSION_PORT:-6380}
echo "INICIANDO REDIS-SESSION *:$REDIS_SESSION_PORT - REDIS_SESSION_DIR:$REDIS_SESSION_DIR"
echo -e "daemonize yes\nprotected-mode no\nport $REDIS_SESSION_PORT\nmaxmemory 384Mb\nmaxmemory-policy allkeys-lru\ndir $REDIS_SESSION_DIR\nlogfile /tmp/redis-session.log\npidfile /var/run/redis-session.pid" > /etc/redis/redis-session.conf
redis-server /etc/redis/redis-session.conf
tail -F /tmp/redis-session.log &

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
