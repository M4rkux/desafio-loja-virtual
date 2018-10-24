<?php
require "models/ProdutoDAO.php";

class ProdutoController {
    private $dao;

    public function ProdutoController(){
        $this->dao = new ProdutoDAO();
        $this->verificarAcao();
    }

    protected function verificarAcao() {
        switch($_SERVER["REQUEST_METHOD"]){
            case "GET":
                if(isset($_GET["id"]) && is_numeric($_GET["id"])){
                    $this->porId($_GET["id"]);
                } else {
                    $this->listar();
                }
                break;
            case "POST":
                $this->salvar();
                break;
            case "PUT":
                $this->atualizar();
                break;
            case "DELETE":
                $this->deletar();
                break;
            case "OPTIONS":
                echo "Allow: GET, POST, PUT, DELETE, OPTIONS";
                break;
            default:
                http_response_code(405);
                echo "Método não implementado";
        }
    }

    protected function listar() {
        $lista = $this->dao->listar();
        if(count($lista) == 0){
            http_response_code(404);
        } else {
            http_response_code(200);
        }
        echo json_encode($lista);
    }

    protected function porId($id) {
        $aluno = $this->dao->porId($id);
        if(!$aluno){
            http_response_code(404);
        } else {
            http_response_code(200);
        }
        echo json_encode($aluno);
    }

    protected function salvar() {
        // Extraindo dados da requisição
        $json = file_get_contents("php://input");
        $dados = json_decode($json, true);
        // Enviado objeto para o DAO
        $id = $this->dao->salvar($dados);
        // Tratando os retornos
        if($id == null){
            http_response_code(500);
        } else {
            http_response_code(201);
        }
        echo json_encode($id);
    }

    protected function atualizar() {
        // Extraindo dados da requisição
        $json = file_get_contents("php://input");
        $dados = json_decode($json, true);
        $dados["id"] = $_GET["id"];
        // Enviado objeto para o DAO
        $retorno = $this->dao->atualizar($dados);
        // Tratando os retornos
        if($retorno == null){
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        echo json_encode($retorno);
    }

    protected function deletar() {
        if(!isset($_GET["id"])){
            http_response_code(400);
            $retorno = false;
        } else {
            $retorno= $this->dao->deletar($_GET["id"]);
            if(!$retorno){
                http_response_code(500);
            } else {
                http_response_code(200);
            }
        }
        echo json_encode($retorno);
    }
}