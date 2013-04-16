<?php

define("PATH", "");
require('lib/aplicacao.php');

class Main extends Template {

    static function exibe_conteudo() {
        
    }

    static function altera_senha() {
        
    }
}

$link = '<link rel="stylesheet" href="css/main.css" type="text/css" />';
Main::exibe_cabecalho('Inicio', $link);
Main::exibe_rodape();
?>