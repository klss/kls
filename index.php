<?php

define("PATH", "");
require('lib/aplicacao.php');

Session::getInstance();
if (sizeof($_GET) == 0) {
    // redirecionar para o modulo padrão
    // TODO modulo padrão deve ser configuravel
    if ($path = KLS::is_module_path('kls.home')) {
        KLS::_include($path);
    }
} else {
    foreach ($_GET as $key => $value) {
        if (empty($value)) {
            $value = 'index.php';
        }

        switch ($key) {
            case KLS::K_NEED_LOGIN:
                if (!empty($_GET['dest'])) {
                    KLS::_include("login/index.php?mod=" . $_GET['dest']);
                } else {
                    KLS::_include("login/index.php");
                }
                break;
            case KLS::K_REG_LOGIN:
                KLS::_include("login/reg_log.php");
                break;
            case KLS::K_NEED_UNIDADE:
                KLS::_include("unidade/index.php");
                break;
            case KLS::K_SET_UNIDADE:
                KLS::_include("unidade/set_unidade.php");
                break;
            case KLS::K_LOGOUT:
                KLS::_include("logout/index.php");
                break;
            case KLS::K_RED_MOD:
                if (!empty($value) && ($path = KLS::is_module_path($value))) {
                    KLS::_include($path);
                }
                break;
            case KLS::K_DIALOG:
                if (!empty($value) && ($path = KLS::is_dialog_path($value))) {
                    KLS::_include($path);
                }
                break;
            case KLS::K_RED_UNI:
                break;
            case KLS::K_RED_ONLY:
                if (!empty($value)) {
                    KLS::_include($value);
                }
                break;
            default:
        }
    }
}
?>
