<?php
class Conexao {
    private static $instancia;
    private $db;
    private function Conexao(){
        $this->db = new PDO("mysql:dbname=dbloja;host=db", "devuser", "devpass");
    }
    public static function getInstance() {
        if(self::$instancia == null){
            self::$instancia = new Conexao();
        }
        return self::$instancia;
    }
    public function getDb(){
        return $this->db;
    }
}