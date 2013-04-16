<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of APP
 *
 * @author Samuel
 */

/**
 * Auto Load
 * Carrega automaticamente os arquivos requisitados (atraves de chamadas as classes),
 * buscando dentro da library do sistema e do modulo.
 * @param String $className
 * @return boolean
 */
function __autoload($className) {

    $class_path = array(
        PATH . "lib/php",
        PATH . "lib/php/template",
        PATH . "lib/php/db",
        PATH . "lib/php/models"
    );

    foreach ($class_path as $path) {
        if (file_exists("$path/$className.php")) {
            require_once("$path/$className.php");
            return true;
        }
    }
    return false;
}

class KLS {

    const NOME_APP = 'SAAG';

    //SESSION KEYS
    const K_CURRENT_MODULE = "SGA_CURRENT_MODULE";
    const K_CURRENT_USER = "SGA_CURRENT_USER";
    const K_MODULE_LOADED = "MODULE_IS_LOADED";

    //REDIRECTION
    const K_NEED_LOGIN = "login";   // redirect to login window
    const K_REG_LOGIN = "reg_log"; // redirect to login register
    const K_NEED_UNIDADE = "unidade"; // redirect to login window
    const K_SET_UNIDADE = "set_uni"; // redirect to login window
    const K_INICIO = "inicio";  // redirect to home page
    const K_LOGOUT = "logout";  // redirect to logout page
    const K_RED_MOD = "mod";     // redirect to module
    const K_RED_UNI = "uni";     // redirect to "unidade" home page
    const K_RED_ONLY = "redir";   // redirect to the informed page
    const K_DIALOG = "dialog";  // redirect to the informed page
    const K_ERROR = "dialog=error_dialog"; // redirect to the informed page
    const K_TRIAGEM_TOUCH = "triagemtouch"; // redirect to the informed page
    // PATHS
    const K_MODULES_PATH = "modulos";

    // ERRORS
    const K_LOGIN_ERROR = "LOGIN_ERROR";

    public static function _include($param) {
        $a = explode('?', $param);
        $url = $a[0];
        if (file_exists($url)) {
            if (sizeof($a) >= 2) {
                foreach (explode('&', $a[1]) as $p) {
                    $vv = explode('=', $p);
                    $_GET[$vv[0]] = urlencode($vv[1]);
                }
            }
            $url = realpath($url);
            $base = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
            // Verificação de Seguranca
            // Checa se o arquivo a ser incluso esta na pasta(ou em uma subpasta) do sga
            if (strpos($url, $base) === 0) {
                include($url);
            }
        }
    }

    public static function is_module_path($mod_path) {
        $a = explode('.', $mod_path);
        if (sizeof($a) == 2) {
            $path = KLS::K_MODULES_PATH . "/" . $a[0] . "/" . $a[1];
            if (file_exists($full_path = "$path/index.php")) {
                return $full_path;
            } else if (file_exists($full_path = "$path/default.php")) {
                return $full_path;
            }
        }
    }

    public static function check_access($mod_key) {
        if ($mod_key == null) {
            throw new Exception('O parametro de check_access() não pode ser null.');
        }
        define('MODULO', $mod_key);
        $modulo = DB::getInstance()->get_modulo($mod_key, Modulo::MODULO_ATIVO);
        if ($modulo == null) {
            throw new Exception("O módulo não existe ou está desativado.");
        }
        Session::getInstance()->setGlobal(KLS::K_CURRENT_MODULE, $modulo);
        if (!KLS::is_logged()) {
            KLS::force_login();
        } else if (!$modulo->is_global() && !KLS::has_unidade()) {
            KLS::force_unidade();
        } else if (!SGA::has_access($modulo)) {
            Template::display_header($modulo->get_nome());
            Template::display_error("Acesso Negado.<br />M&oacute;dulo: " . $modulo->get_nome(), "Acesso Negado.", 0, "location.href='?logout'");
            exit();
        } else {
            $stat_session = DB::getInstance()->verificar_session_id(SGA::get_current_user()->get_id());
            if ($stat_session == Session::SESSION_ENCERRADA) {
                $url = "&onclickok=" . urlencode("window.redir('?logout');") . "&message=" . urlencode("Sessão inválida.<br /><br />Possivelmente esse usuário acessou em outra máquina.");
                header("Location:./?" . SGA::K_ERROR . $url);
                exit();
            } else if ($stat_session == Session::SESSION_DESATUALIZADA) {
                // refresh session
                $old_user = KLS::get_current_user();
                $old_uni = $old_user->get_unidade();
                $new_user = DB::getInstance()->get_usuario_by_id($old_user->get_id());

                if ($old_uni != null) {
                    $new_user->set_unidade(DB::getInstance()->get_unidade($old_uni->get_id()));
                }
                $num_guiche = $old_user->get_num_guiche();
                if (is_int($num_guiche)) {
                    $new_user->set_num_guiche($num_guiche);
                }
                DB::getInstance()->set_session_status($new_user->get_id(), Session::SESSION_ATIVA);
                Session::getInstance()->setGlobal(SGA::K_CURRENT_USER, $new_user);
            } else {
                // set local (no escopo do modulo)
                Session::getInstance()->set(SGA::K_CURRENT_MODULE, $modulo);
                // Chama o loader do modulo caso essa seja a primeira chamada a este modulo
                if (Session::getInstance()->get(K_MODULE_LOADED) !== true) {
                    $loader = 'modules/' . $modulo->get_dir() . "/loader.php";
                    if (file_exists($loader)) {
                        KLS::_include($loader);
                    }
                    Session::getInstance()->set(K_MODULE_LOADED, true);
                }
            }
        }
    }

    public static function has_access(Modulo $modulo) {
        if (KLS::is_logged()) {
            $usuario = KLS::get_current_user();
            $unidade = $usuario->get_unidade();
            $id_usu = $usuario->get_id();

            if ($modulo->is_global()) {
                return DB::getInstance()->has_access_global($id_usu, $modulo->get_id());
            } else {
                // unidade não informada, mas o módulo NÂO é global
                if ($unidade == null) {
                    throw new Exception("A permissão para módulos não globais depende da unidade.");
                }
                // módulo unidade
                return $usuario->get_lotacao()->get_cargo()->has_permissao($modulo->get_id());
            }
        }
        return false;
    }

    public static function force_login() {
        header("Location:./?" . KLS::K_NEED_LOGIN);
    }

    public static function check_login($mod_key) {
        KLS::check_access($mod_key);
    }

    public static function is_logged() {
        return Session::getInstance()->exists(KLS::K_CURRENT_USER);
    }

    public static function import($param) {
        return KLS::_include($param);
    }

    public static function get_current_url() {
        return $_SERVER['PHP_SELF'];
    }

    public static function get_current_page() {
        $url = KLS::get_current_url();
        return end(explode('/', $url));
    }

    public static function is_dialog_path($dialog_name) {
        // aceitar somente nomes com caracters alpha numericos + underline
        if (ctype_alnum(str_replace('_', 'a', $dialog_name))) {
            if (file_exists($full_path = "dialogs/$dialog_name.php")) {
                return $full_path;
            }
        }
        return false;
    }

    /*
     * Retorna a data e hora (a partir da string passada por parametro)
     * @return String
     */

    public static function get_date($date) {
        return date($date, time());
    }

}

?>
