<?php

class ControllerAdmin{
    private $_method;
    private $_modelAdmin;
    private $_idAdmin;

    public function __construct($modelAdmin) {
        $this->_modelAdmin = $modelAdmin;
        $this->_method = $_SERVER['REQUEST_METHOD'];

         //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
         $json = file_get_contents("php://input");
         $datasAdmin = json_decode($json);
 
         $this->_idAdmin = $datasAdmin->idAdmin ?? null;
    }

    function router(){

        switch ($this->_method) {
            case 'GET':

                if (isset($this->_idAdmin)) {
                    return $this->_modelAdmin->login();
                }

                break;

        
            default:
                echo "ERRO. REQUISIÇÃO NÃO ENCONTRADA";
                break;
        }

    }
}

?>