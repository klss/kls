<?php

/**
 * Classe Login
 * Responsavel pelo controle de acesso ao sistema
 *
 */
class Login {

    /**
     * Retorna se os dados informados tem ou nao acesso ao modulo
     *
     * @param String user
     * @param String pass
     * @param String modulo
     * @return int (See AbstractDB::has_acesso())
     */
    public static function has_acesso($user, $pass, $modulo) {
        return DB::getInstance()->has_acesso($user, $pass, $modulo);
    }

}

?>
