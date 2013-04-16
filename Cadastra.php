<?php
define("PATH", "");
require('lib/aplicacao.php');

class Cadastra extends Template {

    static function exibe_cabecalho() {
        $link = '<link rel="stylesheet" href="css/cadastra.css" type="text/css" />' . "\n";
        $titulo = "Produto";
        Template::exibe_cabecalho($titulo, $link);
    }

    static function mostra_form() {
        ?>
        <div id="form-produto">
            <form method='post' action=''>
                <?php Template::exibe_cabecalho_form('Cadastra - Produto'); ?>
                <p>
                    <label class="form-dialogo" for='nome'>Nome:</label>
                    <input class="campo-form" type='email' id='nome' name='nome' autofocus>
                </p>
                <p>
                    <label class="form-dialogo" for='descricao'>Descrição:</label>
                    <input type='text' class="campo-form" id='descricao'>
                </p>
                <p>
                    <label class="form-dialogo" for='preco'>Preço:</label>
                    <input type='text' type="number" class="campo-form" id='preco'>
                </p>
                <p>
                    <label class="form-dialogo" for='categoria'>Categoria:</label>
                    <select type='text' class="campo-form" id='categoria'>
                        <option>-Selecione-</option>
                        <option value="1">Lanche</option>
                        <option value="2">Bebidas</option>
                        <option value="3">Porção</option>
                    </select>
                </p>
                <label class="form-dialogo" >&nbsp;</label>
                <button class="enviar-botao">Cadastrar</button>
                <button class="cancela-botao">Cancelar</button>
            </form>
        </div>
        <?php
    }

}

Cadastra::exibe_cabecalho();
Cadastra::mostra_form();
Template::exibe_rodape();
?>
