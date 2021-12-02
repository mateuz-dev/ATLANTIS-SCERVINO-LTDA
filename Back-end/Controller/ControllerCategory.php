<?php

class ControllerCategory{
    private $_method;
    private $_modelCategory;
    private $_idCategory;

    public function __construct($modelCategory) {
        $this->_modelCategory = $modelCategory;
        $this->_method = $_SERVER['REQUEST_METHOD'];

         //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
         $json = file_get_contents("php://input");
         $datasCategory = json_decode($json);
 
         $this->_idCategory = $datasCategory->idCategory ?? null;
    }

    function router(){

        switch ($this->_method) {
            case 'GET':
            
                
                    return $this->_modelCategory->findAll();
                
                break;

                case 'POST':
                    return $this->_modelCategory->create();
                    break;
    
                case 'PUT':
                    break;
    
                case 'DELETE':

                    return $this->_modelCategory->delete();
                    
                    break;
        
            default:
                echo "ERRO. REQUISIÇÃO NÃO ENCONTRADA";
                break;
        }

    }
}

?>