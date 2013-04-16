<?php

define('MODULO', 'LOGIN');

if (!Session::getInstance()->exists(KLS::K_CURRENT_MODULE)) {
    // TODO módulo padrão deve ser configuravel
    header("Location:?mod=infotv.inicio");
}
if (KLS::is_logged()) {
    header("Location:?mod=" . Session::getInstance()->get(KLS::K_CURRENT_MODULE)->get_chave());
}

$link = '<link rel="stylesheet" href="css/login.css" type="text/css" />' . "\n";
$link .= " <script>
            jQuery(function($) {
                function supportsPlaceholder() {
                    return 'placeholder' in document.createElement('input') &&
                        'placeholder' in document.createElement('textarea');
                }
                if(!supportsPlaceholder()) {
                    $('html').addClass('no-placeholder');
                }
            });
        </script>";

$titulo = "Login";
Template::exibe_cabecalho($titulo, $link);

if (Session::getInstance()->get(KLS::K_LOGIN_ERROR)) {
    Template::display_error(Session::getInstance()->get(KLS::K_LOGIN_ERROR));
    Session::getInstance()->del(KLS::K_LOGIN_ERROR);
}
Template::exibe_login();
Template::exibe_rodape();
?>