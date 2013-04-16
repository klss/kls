<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB
 *
 * @author Samuel
 */
abstract class DB {

    // static
    /** Mantem um instancia unica dessa classe */
    private static $instance;
    // fields
    /** Objeto que retorna as queries apropriadas a um banco específico(MySQL, PostgreSQL, Oracle...) */
    private $m_queries;

    /** Conexão com o banco de dados */
    private $m_connection;

    /**
     * Singleton
     * @return DB
     */
    public static function getInstance() {
        if (DB::$instance === null) {
            $db_class = Config::DB_CLASS;
            DB::$instance = new $db_class;
        }
        return DB::$instance;
    }

    /**
     * Conecta ao banco
     */
    public abstract function connect($host, $port, $usuario, $senha, $banco);

    /**
     * @param DBQueries
     */
    public function set_queries(DBQueries $queries) {
        $this->m_queries = $queries;
    }

    /**
     * @return DBQueries
     */
    public function get_queries() {
        return $this->m_queries;
    }

    /**
     * @return PDO
     */
    public function get_connection() {
        return $this->m_connection;
    }

    /**
     * @return PDO
     */
    public function set_connection(/* PDO */ $pdo) {
        $this->m_connection = $pdo;
    }

    /**
     * Transforma um resultset em array
     * @param PDOStatement statement
     * @return array
     */
    public function to_array($statement) {
        return $statement->fetchAll();
    }

    public function criar_produto($f) {
        $id = $f['id_produto'];
        $nome = $f['nome'];
        $descricao = $f['descricao'];
        $valor = $f['valor'];
        $ativo = $f['ativo'];

        $produto = new Produto($id, $nome, $descricao, $valor, $ativo);
        return $produto;
    }

    /**
     * @param $linha
     * @return unknown_type
     */
    public function criar_modulo($linha) {
        $id = $linha['id_mod'];
        $chave = $linha['chave_mod'];
        $nome = $linha['nm_mod'];
        $descricao = $linha['desc_mod'];
        $autor = $linha['autor_mod'];
        $img = $linha['img_mod'];
        $tipo = $linha['tipo_mod'];
        $modulo = new Modulo($id, $chave, $nome, $autor, $img, $tipo);

        $modulo->set_descricao($descricao);
        $modulo->set_autor($autor);
        if (KLS::is_module_path($chave)) {
            $modulo->set_dir(str_replace('.', '/', $chave));
        }
        return $modulo;
    }

    /**
     * Retorna todos os produtos
     * @return array
     */
    public function get_produtos() {
        $sql = $this->get_queries()->get_produtos();
        $statement = $this->m_connection->prepare($sql);
        $statement->execute();

        $array = DB::to_array($statement);
        $produtos = array();
        foreach ($array as $f) {
            $produto = DB::getInstance()->criar_produto($f);
            $produtos[] = $produto;
        }
        return $produtos;
    }

    public function inserir_produto($nome_prod, $desc_prod, $valor_prod, $ativo) {
        $sql = $this->get_queries()->inserir_produto();

        $statement = $this->m_connection->prepare($sql);
        $statement->bindValue(':nome', $nome_prod, PDO::PARAM_STR);
        $statement->bindValue(':descricao', $desc_prod, PDO::PARAM_STR);
        $statement->bindValue(':valor', $valor_prod, PDO::PARAM_INT);
        $statement->bindValue(':ativo', $ativo, PDO::PARAM_INT);
        $statement->execute();
    }

    /*
     * Retorna os modulos do sistema, a partir do seu status
     *
     * @param int $status
     * @return array
     */

    public function get_modulos($stats_mod = array(Modulo::MODULO_ATIVO, Modulo::MODULO_INATIVO), $tipos_mod = array(Modulo::MODULO_GLOBAL, Modulo::MODULO_UNIDADE)) {
        $sql = $this->get_queries()->get_modulos();

        // verifcação de segurança(SQL Injection), garante que todos valores são números
        // importante pois entrarão direto na consulta
        foreach ($stats_mod as $key => $value) {
            $stats_mod[$key] = (int) $value;
        }
        $stats_mod = implode(",", $stats_mod);

        $sql = str_replace(':stats_mod', $stats_mod, $sql);

        foreach ($tipos_mod as $key => $value) {
            $tipos_mod[$key] = (int) $value;
        }
        $tipos_mod = implode(",", $tipos_mod);
        $sql = str_replace(':tipos_mod', $tipos_mod, $sql);

        $statement = $this->get_connection()->prepare($sql);
        $statement->execute();

        $array = DB::to_array($statement);

        $modulos = array();
        foreach ($array as $m) {
            $modulo = DB::getInstance()->criar_modulo($m);
            $modulos[] = $modulo;
        }

        return $modulos;
    }

    /**
     * Retorna o modulo do sistema especificado pela chave
     * e o status
     *
     * @param String $chave
     * @param int $status
     * @return Modulo
     */
    public function get_modulo($chave, $status) {

        $sql = $this->get_queries()->get_modulo();
        $statement = $this->m_connection->prepare($sql);
        $statement->bindValue(':chave', $chave, PDO::PARAM_STR);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
        $statement->execute();

        $m = DB::to_array($statement);

        $modulo = DB::getInstance()->criar_modulo($m[0]);

        return $modulo;
    }

    /**
     * Retorna se usuario tem ou nao acesso ao modulo
     * Retorno:
     * 	1 = Usuario Invalido
     * 	2 = Modulo Invalido
     * 	3 = Senha Invalida
     * 	4 = Acesso Negado
     * 	-1 = Acesso Liberado (Ok)
     * @param String $user
     * @param String $pass
     * @param String $chave_mod
     * @return int
     */
    public function has_acesso($user, $pass, $chave_mod) {
        $exceptionMessage = "Erro ao tentar efetuar login.";

        $sql = $this->get_queries()->exists_usuario();
        $statement = $this->m_connection->prepare($sql);
        $statement->bindParam(':login_usu', $user, PDO::PARAM_STR);
        $statement->execute();

        if (count(DB::to_array($statement)) == 0)
            return 1; // unknown user

        $sql = $this->get_queries()->exists_modulo();

        $statement = $this->m_connection->prepare($sql);
        $statement->bindValue(':chave_mod', $chave_mod, PDO::PARAM_STR);
        $statement->execute();

        $tmp = DB::to_array($statement);
        $id_mod = $tmp[0][0];

        if (count($tmp) == 0) {
            return 2; // unknown mod
        }

        $sql = $this->get_queries()->get_usuario_login();
        $statement = $this->m_connection->prepare($sql);
        $statement->bindValue(':login_usu', $user, PDO::PARAM_STR);
        $statement->bindValue(':pass', $pass, PDO::PARAM_STR);
        $statement->execute();

        if (count(DB::to_array($statement)) == 0) {
            return 3; // invalid password
        }

        $sql = $this->get_queries()->get_status_usu();
        $statement = $this->m_connection->prepare($sql);
        $statement->bindValue(':login_usu', $user, PDO::PARAM_STR);
        $statement->bindValue(':pass', $pass, PDO::PARAM_STR);
        $statement->execute();

        $status = $this->to_array($statement);
        $status = $status[0][0];

        if ($status == 0) {
            return 5; //inativo
        }
        return -1;
    }

}

?>
