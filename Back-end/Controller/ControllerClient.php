<?php

class ControllerClient{
    private $_method;
    private $_modelClient;
    private $_idClient;

    public function __construct($modelClient) {
        $this->_modelClient = $modelClient;
        $this->_method = $_SERVER['REQUEST_METHOD'];

         //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
         $json = file_get_contents("php://input");
         $dataClients = json_decode($json);
 
         $this->_idClient = $dataClients->idClient ?? null;
    }

    function router(){

        switch ($this->_method) {
            case 'GET':

                if ($this->_modelClient->returnIdClient() !== null) {
                    return $this->_modelClient->findById();
                }

                return $this->_modelClient->findAll();
                break;

            case 'POST':

                if ($this->_modelClient->returnIdClient() !== null) {
                    return $this->_modelClient->update();
                } else {
                    return $this->_modelClient->create();
                }
                break;

            case 'DELETE':
                return $this->_modelClient->delete();
                break;
            
            default:
                echo "ERRO. REQUISIÇÃO NÃO ENCONTRADA";
                break;
        }

    }
}

?>