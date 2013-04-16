<?php

define('MODULO', 'LOGIN');
try {
    $erro = 0;
    Session::getInstance()->set(KLS::K_LOGIN_ERROR, null);
    $messages = array(
        'Usu&aacute;rio Inv&aacute;lido. Por favor, tente novamente.',
        'M&oacute;dulo Inv&aacute;lido. Por favor, entre em contato com o administrador do sistema.',
        'Senha Inv&aacute;lida. Por favor, tente novamente.',
        'Acesso Negado ao M&oacute;dulo. Por favor, entre em contato com seu gerente.',
        'Usu&aacute;rio desativado. Por favor, entre em contato com seu gerente'
    );
    if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {
        $user = $_POST['usuario'];
        $pass = $_POST['senha'];
        Session::del('_senha_inicio');
        if (Session::getInstance()->exists(KLS::K_CURRENT_MODULE)) {
            $mod = Session::getInstance()->get(KLS::K_CURRENT_MODULE)->get_chave();
            $erro = Login::has_acesso($user, $pass, $mod);
            if ($erro == -1) {
                define('MODULO', $mod);
                $usuario = DB::getInstance()->get_usuario($user);
                Session::getInstance()->setGlobal(KLS::K_CURRENT_USER, $usuario);
                DB::getInstance()->salvar_session_id($usuario->get_id());
                DB::getInstance()->set_session_status($usuario->get_id(), Session::SESSION_ATIVA);
                Session::getInstance()->del('_acessou');
                header("Location:./?mod=$mod");
            } else {
                Session::getInstance()->set(KLS::K_LOGIN_ERROR, $messages[$erro - 1]);
                header("Location:./?" . KLS::K_NEED_LOGIN);
            }
        } else {
            Session::getInstance()->set(KLS::K_LOGIN_ERROR, "Nenhum m&oacute;dulo carregado.");
            header("Location:./?" . KLS::K_NEED_LOGIN);
        }
    } else {
        header("Location:./?" . KLS::K_NEED_LOGIN);
    }
} catch (Exception $e) {
    Template::display_exception($e);
}
?>