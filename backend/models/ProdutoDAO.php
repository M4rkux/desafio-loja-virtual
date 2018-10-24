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
        return $resultado->fetchAll();
    }

    public function porId($id) {
        $stmt = $this->conexao->prepare('SELECT * FROM produto WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function salvar($objeto){
        $nome = $objeto["nome"];
        $preco = $objeto["preco"];
        $quantidade = $objeto["quantidade"];
         
        $stmt->conexao->prepare('INSERT INTO produto(nome, preco, quantidade) VALUES (":nome", ":preco", :quantidade)');
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        
        if(!$resultado){
            return null;
        } else {
            return $this->conexao->insert_id;
        }
    }

    public function atualizar($objeto) {
        $nome = $objeto["nome"];
        $preco = $objeto["preco"];
        $quantidade = $objeto["quantidade"];
        $id = $objeto["id"];
         
        $stmt = $this->conexao->prepare('UPDATE produto SET nome = ":nome", preco = ":preco", quantidade = :quantidade WHERE id = :id');
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        if(!$resultado){
            return null;
        } else {
            return true;
        }
    }

    public function remover($id) {
        $stmt = $this->conexao->prepare('DELETE FROM produto WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $smt->execute();
    }
}