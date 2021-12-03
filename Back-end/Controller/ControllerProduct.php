<?php

class ControllerProduct{
    private $_method;
    private $_modelProduct;
    private $_idProduct;

    public function __construct($modelProduct) {
        $this->_modelProduct = $modelProduct;
        $this->_method = $_SERVER['REQUEST_METHOD'];

         //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
         $json = file_get_contents("php://input");
         $dataProducts = json_decode($json);
 
        //  $this->_idProduct = $dataProducts->idProduct ?? null;
    }

    function router(){

        switch ($this->_method) {
            case 'GET':

                if (isset($this->_idProduct)) {
                    return $this->_modelProduct->findById();
                }

                return $this->_modelProduct->findAll();
                break;

            case 'POST':
                if ($this->_modelProduct->returnIdProduct() !== null) {
                    return $this->_modelProduct->update();
                } else {
                    return $this->_modelProduct->create();
                }
                break;

            case 'DELETE':
                return $this->_modelProduct->delete();
                break;
            
            default:
                echo "ERRO. REQUISIÇÃO NÃO ENCONTRADA";
                break;
        }

    }
}

?>