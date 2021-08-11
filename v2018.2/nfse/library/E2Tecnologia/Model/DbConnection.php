<?php

/**
 * Classe modelo para models que utilizam tabelas do e-cidade
 */
class E2Tecnologia_Model_DbConnection {

      var $host = '192.168.25.19';
      var $port = '5432';
      var $dbname = 'alegrete3';
      var $user = 'postgres';
      var $password = '';
      var $query = '';
      var $pdo = null;
      
      function __construct() {
         $this->pdo = new PDO("pgsql:host=$this->host;
                 port=$this->port;
                 dbname=$this->dbname;
                 user=$this->user;
                 password=$this->password");
        //seta para imprimir e parar script quando PDO lançar erro
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($str) {
        $this->query = $str;
    }

    private function prepare() {
        return $this->pdo->prepare($this->query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    }

    public function fetch($arr = null, $debug = false) {
        if ($arr == null)
            $arr = array();
        if (!$debug) {
            $sth = $this->prepare();
            $sth->execute($arr);
            return $sth->fetchAll();
        }else {
            echo $this->query;
            echo "<br>"; print_r($arr);
        }
    }

    public function execute($arr = null) {
        if ($arr == null)
            $arr = array();
        $sth = $this->prepare();
        return $sth->execute($arr);
    }

    public function query_fetch($sql, $arr) {
        $this->query($sql);
        return $this->fetch($arr);
    }
}

?>
