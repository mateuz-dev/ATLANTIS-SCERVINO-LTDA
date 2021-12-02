<?php

class ModelAdmin{

    private $_conn;
    private $_idAdmin;
    private $_user;
    private $_password;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasAdmin = json_decode($json);

        $this->_idAdmin = $_REQUEST['idAdmin'] ?? $datasAdmin->idAdmin ??  null;
        $this->_user = $_POST['user'] ?? $datasAdmin->user ?? null;
        $this->_password = $_POST['password'] ?? $datasAdmin->password ?? null;

        $this->_conn = $conn;

    }

    public function login(){


        $sql = "SELECT user, password FROM tblAdmin WHERE user = ? AND password = ?";
        $stm = $this->_conn->prepare($sql);
        

        $encryptedPassword = password_hash($this->_password, PASSWORD_DEFAULT);

        $stm->bindValue(1, $this->_user);
        $stm->bindValue(2, $encryptedPassword);
     

        if ($stm->execute()) {
            return "Login feito com sucesso";
        } else {
            return "Erro";
        }
    
    }


}    