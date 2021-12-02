<?php

class ModelClient{

    private $_conn;
    private $_idClient;
    private $_name;
    private $_email;
    private $_password;
    private $_cpf;
    private $_birthDate;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasClient = json_decode($json);

        $this->_idClient = $_REQUEST['idClient'] ?? $datasClient->idClient ??  null;
        $this->_name = $_POST['name'] ?? $datasClient->name ?? null;
        $this->_email = $_POST['email'] ?? $datasClient->email ?? null;
        $this->_password = $_POST['password'] ?? $datasClient->password ?? null;
        $this->_cpf = $_POST['cpf'] ?? $datasClient->cpf ?? null;
        $this->_birthDate = $_POST['birthDate'] ?? $datasClient->birthDate ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){
        $sql = "SELECT name, email, cpf, birthDate FROM tblClient";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(){

        $sql = "SELECT name, email, cpf, birthDate FROM tblClient WHERE idClient = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idClient);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function create(){

        $sql = "INSERT INTO tblClient (name, email, password, cpf, birthDate)
            VALUES (?, ?, ?, ?, ?)";

        $stm = $this->_conn->prepare($sql);

        $encryptedPassword = password_hash($this->_password, PASSWORD_DEFAULT);

        $stm->bindValue(1, $this->_name);
        $stm->bindValue(2, $this->_email);
        $stm->bindValue(3, $encryptedPassword);
        $stm->bindValue(4, $this->_cpf);
        $stm->bindValue(5, $this->_birthDate);

        if ($stm->execute()){
            return "Sucess";
        } else {
            return "Error";
        }
    }

    public function delete(){

        $sql = "DELETE FROM tblClient WHERE idClient = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idClient);

        if ($stmt->execute()) {
            return "Dados excluídos com sucesso!";
        } else {
            return "Erro";
        }

    }

    public function update(){

        if ($this->_password !== "") {
            $sql = "UPDATE tblClient SET 
            name = ?, 
            email = ?, 
            password = ?, 
            cpf = ?, 
            birthDate = ?
            WHERE idClient = ?";

            $stmt = $this->_conn->prepare($sql);

            

            $stmt->bindValue(1, $this->_name);
            $stmt->bindValue(2, $this->_email);
            $stmt->bindValue(3, $encryptedPassword);
            $stmt->bindValue(4, $this->_cpf);
            $stmt->bindValue(5, $this->_birthDate);
            $stmt->bindValue(6, $this->_idClient);
        } else {
                $sql = "UPDATE tblClient SET 
                name = ?, 
                email = ?, 
                cpf = ?, 
                birthDate = ?
                WHERE idClient = ?";
    
                $stmt = $this->_conn->prepare($sql);
    
                $stmt->bindValue(1, $this->_name);
                $stmt->bindValue(2, $this->_email);
                $stmt->bindValue(3, $this->_cpf);
                $stmt->bindValue(4, $this->_birthDate);
                $stmt->bindValue(5, $this->_idClient);
        }

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

}

?>