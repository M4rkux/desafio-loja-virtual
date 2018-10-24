<?php
class RotaController {
    
    public function RotaController() {
        $recurso = $this->extrairParametros();
        $controller = ucfirst($recurso) . "Controller";
        $arquivo = "controllers/$controller.php";
        
        if(!file_exists($arquivo)){
            http_response_code(404);
            echo "Recurso não encontrado";
        } else {
            require $arquivo;
            new $controller();
        }
    }
    private function extrairParametros() {
        $recurso = null;
        $id = 0;
        if(!isset($_GET["param"])){
            http_response_code(404);
            echo "Recurso não encontrado";
            exit;
        } else {
            $url = $_GET["param"];
            $partes = explode("/", $url);
            if(isset($partes[1])){
                $_GET["id"] = $partes[1];
            }
            $recurso = strtolower(trim($partes[0]));
            return $recurso;
        }
    }
}