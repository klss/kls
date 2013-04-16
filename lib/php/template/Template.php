<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Default
 *
 * @author Samuel
 */
class Template {

//put your code here
    static function exibe_cabecalho($titulo = '', $links = '') {
        ?>
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-br">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta http-equiv="Content-Language" content="pt-br"/>
                <?php $titulo = ($titulo == '') ? 'Atendimento' : $titulo; ?>
                <title><?php echo KLS::NOME_APP, ': ', $titulo; ?></title>
                <link href="img/favicon.ico" rel="shortcut icon"/>
                <link href="css/normalize.css" rel="stylesheet"/>
                <link href="css/default.css" rel="stylesheet"/>
                <link href="lib/js/jquery/css/smoothness/jquery-ui-1.10.0.custom.css" rel="stylesheet"/>
                <script src="lib/js/jquery/js/jquery-1.9.0.js"></script>
                <script src="lib/js/jquery/js/jquery-ui-1.10.0.custom.js"></script>
                <?php echo $links; ?>
            </head>
            <body>
                <div id ="geral">
                    <?php
                }

                static function exibe_cabecalho_form($title) {
                    ?>
                    <div class="cabecalho-form">
                        <label><?php echo $title; ?></label>
                    </div>
                    <?php
                }

                static function mostra_botao() {
                    
                }

                /**
                 * Exib e o painel de login do sistema
                 */
                static function exibe_login() {
                    ?>
                    <div id="logo-login">
                        <label class="nome-logo"><?php echo KLS::NOME_APP; ?></label>
                        <label class="descricao-logo">Sistema de Auto-Atendimento Gerenciável</label>
                    </div>
                    <div id="form-login">
                        <form method='post' action='?reg_log'>
                            <?php Template::exibe_cabecalho_form('Login'); ?>
                            <p>
                                <label for='usuario' class="form-dialogo">Usuário:</label>
                                <input class="campo-form" type='text' id='usuario' name='usuario' autofocus placeholder='Usuário'>
                            </p>
                            <p>
                                <label for='senha' class="form-dialogo">Senha:</label>
                                <input class="campo-form" type='password' id='senha' name="senha" placeholder='Senha'>
                            </p>
                            <div class="rodape-login">
                                <label class="form-dialogo">&nbsp;</label>
                                <button class="enviar-botao">Acessar</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }

                /**
                 * Rodape da pagina
                 */
                static function exibe_rodape() {
                    ?>
                </div>
            </body>
        </html>
        <?php
    }

    static function display_exception(Exception $e, $title = 'Erro', $onClickOk = '', $blackout = 0) {
        $debug = false; //TODO isso deve ser configuravel
        $message = $e->getMessage();
        if ($debug) {
            $message .= '<pre>' . $e->getTraceAsString() . '</pre';
        }
        Template::display_error($message, $title, $blackout, $onClickOk);
    }

    static function display_error($message, $title = 'Erro', $blackout = 0, $onClickOk = '') {
        Template::display_popup_header($title);
        ?>
        <div id="window_popup_icon">
            <img src="themes/sga.default/imgs/dialog-error.png"/>
        </div>
        <div id="window_popup_content">
            <div id="window_error_dialog_message">
                <p><?php echo $message; ?></p>
            </div>
        </div>
        <div id="window_popup_controls">
            <input id="btn_window_error_ok" class="button" type="button" onclick="window.closePopup(this);<?php echo $onClickOk; ?>" value="Ok" />
        </div>
        <script type="text/javascript">
            SGA.addOnLoadListener(function() {
                SGA.seleciona("btn_window_error_ok");
            });
        </script>
        <?php
        Template::display_popup_footer();
    }

    static function display_popup_header($title = '') {
        ?>
        <div class="window_popup">
            <div class="window_popup_title">
                <?php echo SGA::NAME, ': ', $title; ?>
            </div>
            <?php
        }

        static function display_popup_footer() {
            ?>
        </div>
        <?php
    }

}
?>
