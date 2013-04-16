<?php
define("PATH", "");
require('lib/aplicacao.php');

class Login extends Template {

    static function exibe_tudo() {
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
        Login::exibe_login();
        Template::exibe_rodape();
    }

    

}

Login::exibe_tudo();
?>
