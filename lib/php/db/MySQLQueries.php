<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySQLQueries
 *
 * @author Samuel
 */
class MySQLQueries implements DBQueries {

    private static $instance;

    // Singleton
    public static function getInstance() {
        if (MySQLQueries::$instance === null)
            MySQLQueries::$instance = new MySQLQueries();
        return MySQLQueries::$instance;
    }

    public function get_produtos() {
        return "SELECT * FROM produtos WHERE ativo = 0";
    }

    public function inserir_produto() {
        return "INSERT INTO produtos
                        (
                         nome,valor,descricao,ativo
                         )
                        VALUES
                       (
                       :nome,:valor,:descricao,:ativo
                       )";
    }

    public function get_modulos() {
        return "SELECT *
		        FROM modulos 
		        WHERE stat_mod IN (:stats_mod)
                    AND tipo_mod IN (:tipos_mod)
		        ORDER BY nm_mod ASC";
    }

    public function get_modulo() {
        return "SELECT *
		        FROM modulos  
		        WHERE chave_mod = :chave
		        AND stat_mod = :status";
    }

}

?>
