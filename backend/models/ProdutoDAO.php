<?php
require "db/Conexao.php";

class ProdutoDAO {

    private $conexao;
    
    public function ProdutoDAO() {
        $conexao = Conexao::getInstance();
        $this->conexao = $conexao->getDb();
    }

    public function listar() {
        $sql = "SELECT * FROM produto ORDER BY id DESC";
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

        $stmt = $this->conexao->prepare('INSERT INTO produto(nome, preco, quantidade) VALUES (:nome, :preco, :quantidade)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->execute();

        return $this->conexao->lastInsertId();
    }

    public function atualizar($objeto) {
        $nome = $objeto["nome"];
        $preco = $objeto["preco"];
        $quantidade = $objeto["quantidade"];
        $id = $objeto["id"];
         
        $stmt = $this->conexao->prepare('UPDATE produto SET nome = :nome, preco = :preco, quantidade = :quantidade WHERE id = :id');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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