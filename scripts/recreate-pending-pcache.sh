#!/bin/bash

# Loop infinito para executar o script a cada hora
while true; do
    DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
    CDIR=$( pwd )

    cd $DIR

    LOG_HOOK=true REQUEST_METHOD='CLI' REMOTE_ADDR='127.0.0.1' REQUEST_URI='/' SERVER_NAME=127.0.0.1 SERVER_PORT="8000" php ../src/tools/recreate-pending-pcache.php

    cd $CDIR

    # Espera 1 hora (3600 segundos) antes de executar novamente
    sleep 3600
done
