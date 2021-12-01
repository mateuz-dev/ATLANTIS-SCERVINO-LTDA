<?php

class ModelAdmin{

    private $_conn;
    private $_idAdmin;
    // private $_user;
    // private $_password;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasAdmin = json_decode($json);

        $this->_idAdmin = $_REQUEST['idAdmin'] ?? $datasAdmin->idAdmin ??  null;
        // $this->_user = $_POST['user'] ?? $datasAdmin->user ?? null;
        // $this->_password = $_POST['password'] ?? $datasAdmin->password ?? null;

        $this->_conn = $conn;

    }

    public function login(){


        $sql = "SELECT user, password FROM tblAdmin WHERE idAdmin = ?";
        $stm = $this->_conn->prepare($sql);
        
        // $passwordVerify = password_verify($this->_password, PASSWORD_DEFAULT);

        $stm->bindValue(1, $this->_idAdmin);
        $stm->execute();

        
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


}    