<?php

return [
    // Usuário de autenticação no Brevo (anteriormente Sendinblue)
    'mailer.user'       => '770eeb001@smtp-brevo.com',

    // Chave de API usada como senha para autenticação no Brevo
    'mailer.psw'        => 'xsmtpsib-7f8fe4b56c8e67abe1710c8759d0df3b071dcc06b415ba4fa9fc2822a062fb54',

    // Protocolo de segurança utilizado (TLS)
    'mailer.protocol'   => 'tls',

    // Servidor SMTP do Brevo
    'mailer.server'     => 'smtp-relay.brevo.com',

    // Porta usada para a conexão com TLS (587)
    'mailer.port'       => '587',

    // E-mail remetente das mensagens
    'mailer.from'       => '770eeb001@smtp-brevo.com',

    // Redirecionar todos os e-mails para um endereço específico (se necessário)
    'mailer.alwaysTo'   => false,

    // Transporte de e-mail com opção de desabilitar verificação de certificado (para testes)
    'mailer.transport'  => 'smtp+tls://770eeb001@smtp-brevo.com:xsmtpsib-7f8fe4b56c8e67abe1710c8759d0df3b071dcc06b415ba4fa9fc2822a062fb54@smtp-relay.brevo.com:587?auth_mode=login',

];
