<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Produto
 *
 * @author Samuel
 */
class Produto {

    private $id;
    private $nome;
    private $descricao;
    private $valor;
    private $ativo;

    /**
     * 
     * @param INT $id
     * @param STR $nome
     * @param STR $descricao
     * @param DOUBLE $valor
     * @param INT $ativo
     */
    public function __construct($id, $nome, $descricao, $valor, $ativo) {
        $this->set_id($id);
        $this->set_nome($nome);
        $this->set_descricao($descricao);
        $this->set_valor($valor);
        $this->set_ativo($ativo);
    }

    public function set_id($id) {
        $this->id = $id;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_descricao($descricao) {
        $this->descricao = $descricao;
    }

    public function get_descricao() {
        return $this->descricao;
    }

    public function set_valor($valor) {
        $this->valor = $valor;
    }

    public function get_valor() {
        return $this->valor;
    }

    public function set_ativo($ativo) {
        $this->ativo = $ativo;
    }

    public function get_ativo() {
        return $this->ativo;
    }

}

?>
