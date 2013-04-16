<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author Samuel
 */
class Session {
    /** Sessão encerrada: Usuário deslogado. */

    const SESSION_ENCERRADA = 0;

    /** Sessão ativa: Usuário logado. */
    const SESSION_ATIVA = 1;

    /**
     * Sessão com dados fora de sincronia com o Banco de Dados,
     * o próximo acesso a qualquer página do sistema irá efetuar
     * uma recarga transparente da Sessão e retornar ao status SESSION_ATIVA.
     */
    const SESSION_DESATUALIZADA = 2;

    public static $session;

    public function __construct() {
        session_start();
    }

    /**
     * @return Session session
     */
    public static function getInstance() {
        if (Session::$session === null)
            Session::$session = new Session();
        return Session::$session;
    }

    /**
     * Define ou adicionar um valor na sessao
     * @param String $chave
     * @param mixed $valor
     */
    public function set($chave, $valor) {
        $_SESSION[MODULO][$chave] = $valor;
    }

    /**
     * Define ou adicionar um valor na sessao Global
     * @param String $chave
     * @param mixed $valor
     */
    public function setGlobal($chave, $valor) {
        $_SESSION['GLOBAL'][$chave] = $valor;
    }

    /**
     * Retorna o valor da chave guardada na sessao
     * @param String $chave
     * @return mixed
     */
    public function get($chave) {
        if (isset($_SESSION[MODULO][$chave]))
            return $_SESSION[MODULO][$chave];
        if (isset($_SESSION['GLOBAL'][$chave]))
            return $_SESSION['GLOBAL'][$chave];
        return false;
    }

    /**
     * Retorna se a chave informada ja esta
     * guardada na sessao
     * @param String $chave
     * @return bool
     */
    public function exists($chave) {
        return (isset($_SESSION[MODULO][$chave])) || (isset($_SESSION['GLOBAL'][$chave]));
    }

    /**
     * Remove da sessao a chave informada.
     * Retorna true se a chave existe e false caso nao exista
     * @param String $chave
     * @return bool
     */
    public function del($chave) {
        if (isset($_SESSION[MODULO][$chave])) {
            unset($_SESSION[MODULO][$chave]);
            return true;
        }
        if (isset($_SESSION['GLOBAL'][$chave])) {
            unset($_SESSION['GLOBAL'][$chave]);
            return true;
        }
        return false;
    }

    /**
     * Remove todos valores armazenados, mas mantem a session viva
     */
    public function reset() {
        $_SESSION = array();
    }

    /**
     * Destroi (encerra) a sessao, removendo
     * todos os valores guardados
     */
    public function destroy() {
        $_SESSION = array();
        session_destroy();
    }

}

?>
