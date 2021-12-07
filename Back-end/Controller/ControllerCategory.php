<?php

class ControllerCategory{
    private $_method;
    private $_modelCategory;

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
                if ($this->_modelCategory->returnIdCategory() !== null) {
                    return $this->_modelCategory->findById();
                } else {
                    return $this->_modelCategory->findAll();
                }
                
                break;

                case 'POST':
                    if($this->_modelCategory->returnIdCategory() !== null){
                        return $this->_modelCategory->update();
                    } else {
                        return $this->_modelCategory->create();
                    }
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