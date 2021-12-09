<?php

class ControllerColor{
    private $_method;
    private $_modelColor;
    private $_idColor;

    public function __construct($modelColor) {
        $this->_modelColor = $modelColor;
        $this->_method = $_SERVER['REQUEST_METHOD'];

         //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
         $json = file_get_contents("php://input");
         $dataColors = json_decode($json);
 
         $this->_idColor = $dataColors->idColor ?? null;
    }

    function router(){
        return $this->_modelColor->findAll();
    }
}

?>