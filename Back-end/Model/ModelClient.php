<?php
class ModelClient{

    private $_conn;
    private $_idClient;
    private $_name;
    private $_email;
    private $_password;
    private $_cpf;
    private $_birthDate;
    private $_profilePhoto;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasClient = json_decode($json);

        $this->_idClient = $_REQUEST['idClient'] ?? $datasClient->idClient ??  null;
        $this->_name = $_POST['name'] ?? $datasClient->name ?? null;
        $this->_email = $_POST['email'] ?? $datasClient->email ?? null;
        $this->_password = $_POST['password'] ?? $datasClient->password ?? null;
        $this->_cpf = $_POST['cpf'] ?? $datasClient->cpf ?? null;
        
        $this->_birthDate = $_POST['birthDate'] ?? $datasClient->birthDate ?? null;

        $this->_profilePhoto = $_FILES['profilePhoto'] ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){
        $sql = "SELECT idClient, name, birthDate, profilePhoto FROM tblClient";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(){

        $sql = "SELECT idClient, name, birthDate, profilePhoto FROM tblClient WHERE idClient = ?";
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

        $stm->execute();

        if ($this->_profilePhoto['name'] !== "" &&
            $this->_profilePhoto['name'] !== null) {

            $extension = pathinfo($this->_profilePhoto['name'], PATHINFO_EXTENSION);
            $profilePhotoName = md5(microtime()) . ".$extension";
            $path = "../Uploads/UploadClient/" . $profilePhotoName;
            move_uploaded_file($this->_profilePhoto["tmp_name"], $path);

            $sql = "UPDATE tblClient SET 
            profilePhoto = ?
            WHERE idClient = ?";

            $stmt = $this->_conn->prepare($sql);

            $lastIdClient = $this->_conn->lastInsertId();

            $stmt->bindValue(1, $profilePhotoName);
            $stmt->bindValue(2, $lastIdClient);

            $stmt->execute();
        }
    }

    public function delete(){

        $photoName = null;

        //Deletar imagem da pasta
        $sql = "SELECT profilePhoto FROM tblClient WHERE idClient = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idClient);
        $stm->execute();

        if ($stm->execute()) {
            $photoName = $stm->fetchAll()[0]['profilePhoto'];
        }

        $sql = "DELETE FROM tblClient WHERE idClient = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idClient);

        if ($stmt->execute()) {
            if ($photoName !== null &&
            $photoName !== '') {
                unlink("../Uploads/UploadClient/" . $photoName);
            }   
            return "Dados excluídos com sucesso!";
        } else {
            return "Erro";
        }

    }

    public function update(){
        
        if ($this->_profilePhoto['name'] !== "" &&
            isset($this->_profilePhoto['name'])) {
            $sql = "SELECT profilePhoto FROM tblClient WHERE idClient = ?";
            $stm = $this->_conn->prepare($sql);
            $stm->bindValue(1, $this->_idClient);

            if ($stm->execute()) {
                $photoName = $stm->fetchAll()[0]['profilePhoto'];

                if (isset($photoName) &&
                $photoName !== '') {
                    unlink("../Uploads/UploadClient/" . $photoName);
                }

                $extension = pathinfo($this->_profilePhoto['name'], PATHINFO_EXTENSION);
                $profilePhotoName = md5(microtime()) . ".$extension";
                $path = "../Uploads/UploadClient/" . $profilePhotoName;
                move_uploaded_file($this->_profilePhoto["tmp_name"], $path);

                $sql = "UPDATE tblClient SET 
                profilePhoto = ?
                WHERE idClient = ?";

                $stmt = $this->_conn->prepare($sql);

                $stmt->bindValue(1, $profilePhotoName);
                $stmt->bindValue(2, $this->_idClient);

                $stmt->execute();
            }
        }

        //Caso seja perceptível requisição para alterar senha
        if ($this->_password !== "" &&
            isset($this->_password)) {
            $sql = "UPDATE tblClient SET 
            password = ?
            WHERE idClient = ?";

            $stmt = $this->_conn->prepare($sql);

            $encryptedPassword = password_hash($this->_password, PASSWORD_DEFAULT);

            $stmt->bindValue(1, $encryptedPassword);
            $stmt->bindValue(2, $this->_idClient);

            $stmt->execute();
        }

        //Caso seja perceptível requisição para alterar email
        if ($this->_email !== "" &&
            isset($this->_email)) {
            $sql = "UPDATE tblClient SET 
            email = ?
            WHERE idClient = ?";

            $stmt = $this->_conn->prepare($sql);

            $stmt->bindValue(1, $this->_email);
            $stmt->bindValue(2, $this->_idClient);

            $stmt->execute();
        }
        
        $sql = "UPDATE tblClient SET 
        name = ?, 
        cpf = ?, 
        birthDate = ?
        WHERE idClient = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_name);
        $stmt->bindValue(2, $this->_cpf);
        $stmt->bindValue(3, $this->_birthDate);
        $stmt->bindValue(4, $this->_idClient);
        

        $stmt->execute();
    }

    public function returnIdClient(){
        return $this->_idClient;
    }

}

?>