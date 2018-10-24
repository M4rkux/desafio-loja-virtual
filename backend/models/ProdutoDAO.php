<?php
require "db/Conexao.php";

class ProdutoDAO {

    private $conexao;
    
    public function ProdutoDAO() {
        $conexao = Conexao::getInstance();
        $this->conexao = $conexao->getDb();
    }

    public function listar() {
        $sql = "SELECT * FROM produto";
        $resultado = $this->conexao->query($sql);
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function porId($id) {
        $stmt = $this->conexao->prepare('SELECT * FROM produto WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function salvar($objeto){
        $nome = $objeto["nome"];
        $preco = $objeto["preco"];
        $quantidade = $objeto["quantidade"];

        $stmt = $this->conexao->prepare('INSERT INTO produto(nome, preco, quantidade) VALUES (?, ?, ?)');
        $stmt->bindParam(1, $nome, PDO::PARAM_STR);
        $stmt->bindParam(2, $preco, PDO::PARAM_STR);
        $stmt->bindParam(3, $quantidade, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
        
        // if(!$stmt->rowCount()){
        //     return null;
        // } else {
        //     return $this->conexao->insert_id;
        // }
    }

    public function atualizar($objeto) {
        $nome = $objeto["nome"];
        $preco = $objeto["preco"];
        $quantidade = $objeto["quantidade"];
        $id = $objeto["id"];
         
        $stmt = $this->conexao->prepare('UPDATE produto SET nome = ?, preco = ?, quantidade = ? WHERE id = ?');
        $stmt->bindParam(1, $nome, PDO::PARAM_STR);
        $stmt->bindParam(2, $preco, PDO::PARAM_STR);
        $stmt->bindParam(3, $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        if(!$resultado){
            return null;
        } else {
            return true;
        }
    }

    public function deletar($id) {
        $stmt = $this->conexao->prepare('DELETE FROM produto WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}