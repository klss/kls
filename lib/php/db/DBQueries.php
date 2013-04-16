<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBQueries
 *
 * @author Samuel
 */
interface DBQueries {

    //put your code here
    public function get_produtos();

    public function inserir_produto();
    
    public function get_modulo();
    
    public function get_modulos();
    
    public function exists_usuario();
    
    public function exists_modulo();
    
    public function get_usuario_login();
    
    public function get_status_usu();
}

?>
