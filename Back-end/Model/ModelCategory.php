<?php

class ModelCategory{

    private $_conn;
    private $_idCategory;
    private $_name;
    private $_icon;
    private $_backgroundImage;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasCategory = json_decode($json);

        $this->_idCategory = $_REQUEST['idCategory'] ?? $datasCategory->idCategory ??  null;
        $this->_name = $_POST['name'] ?? $datasCategory->name ?? null;
        $this->_icon = $_FILES['icon'] ?? null;
        $this->_backgroundImage = $_FILES['backgroundImage'] ?? null;

        $this->_conn = $conn;

    }

    public function findAll(){
        
        $sql = "SELECT * FROM tblCategory";

        $stm = $this->_conn->prepare($sql);
        
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function findById(){

        $sql = "SELECT * FROM tblCategory WHERE idCategory=?";

        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(){
        $sql = "INSERT INTO tblCategory (name, icon, backgroundImage)
                VALUES (?, ?, ?)";

        if (
            isset($this->_icon) && 
            $this->_icon['tmp_name'] !== '' && 
            isset($this->_backgroundImage) &&
            $this->_backgroundImage['tmp_name'] !== '' &&
            isset($this->_name) &&
            $this->_name !== ''
            ) {
        
            $extensionIcon = pathinfo($this->_icon['name'], PATHINFO_EXTENSION);
            $newIconName = md5(microtime()) . ".$extensionIcon";
            $extensionBackgroundImage = pathinfo($this->_backgroundImage['name'], PATHINFO_EXTENSION);
            $newbackgroundName = md5(microtime()) . ".$extensionBackgroundImage";
            move_uploaded_file($_FILES['icon']['tmp_name'], "../Uploads/UploadCategory/icon/$newIconName");
            move_uploaded_file($_FILES['backgroundImage']['tmp_name'], "../Uploads/UploadCategory/background/$newbackgroundName");

            $stm = $this->_conn->prepare($sql);

            $stm->bindValue(1, $this->_name);
            $stm->bindValue(2, $newIconName);
            $stm->bindValue(3, $newbackgroundName);

            if ($stm->execute()){
                return "Sucess";
            } else {
                return "Error";
            }
        }
    }

    public function delete(){

        //Deletar imagem da pasta
        $sql = "SELECT icon FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        $iconName = $stm->fetchAll()[0]['icon'];

        $sql = "SELECT backgroundImage FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        $backgroundName = $stm->fetchAll()[0]['backgroundImage'];

        //Deletar categoria no sql

        $sql = "DELETE FROM tblCategory WHERE idCategory = ?";

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_idCategory);

        if ($stm->execute()) {
            unlink("../Uploads/UploadCategory/icon/" . $iconName);
            unlink("../Uploads/UploadCategory/background/" . $backgroundName);
            
        } else {
            return "Erro";
        }

    }

    public function update(){

        if ($this->_icon['name'] !== "" &&
            isset($this->_icon['name'])) {
            $sql = "SELECT icon FROM tblCategory WHERE idCategory = ?";
            $stm = $this->_conn->prepare($sql);
            $stm->bindValue(1, $this->_idCategory);

            if ($stm->execute()) {
                $photoName = $stm->fetchAll()[0]['icon'];

                if (isset($photoName) &&
                $photoName !== '') {
                    unlink("../Uploads/UploadCategory/icon/" . $photoName);
                }

                $extension = pathinfo($this->_icon['name'], PATHINFO_EXTENSION);
                $iconName = md5(microtime()) . ".$extension";
                $path = "../Uploads/UploadCategory/icon/" . $iconName;
                move_uploaded_file($this->_icon["tmp_name"], $path);

                $sql = "UPDATE tblCategory SET 
                icon = ?
                WHERE idCategory = ?";

                $stmt = $this->_conn->prepare($sql);

                $stmt->bindValue(1, $iconName);
                $stmt->bindValue(2, $this->_idCategory);

                $stmt->execute();
            }
        }

        if ($this->_backgroundImage['name'] !== "" &&
            isset($this->_backgroundImage['name'])) {
            $sql = "SELECT backgroundImage FROM tblCategory WHERE idCategory = ?";
            $stm = $this->_conn->prepare($sql);
            $stm->bindValue(1, $this->_idCategory);

            if ($stm->execute()) {
                $photoName = $stm->fetchAll()[0]['backgroundImage'];

                if (isset($photoName) &&
                $photoName !== '') {
                    unlink("../Uploads/UploadCategory/background/" . $photoName);
                }

                $extension = pathinfo($this->_backgroundImage['name'], PATHINFO_EXTENSION);
                $backgroundImageName = md5(microtime()) . ".$extension";
                $path = "../Uploads/UploadCategory/background/" . $backgroundImageName;
                move_uploaded_file($this->_backgroundImage["tmp_name"], $path);

                $sql = "UPDATE tblCategory SET 
                backgroundImage = ?
                WHERE idCategory = ?";

                $stmt = $this->_conn->prepare($sql);

                $stmt->bindValue(1, $backgroundImageName);
                $stmt->bindValue(2, $this->_idCategory);

                $stmt->execute();
            }
        }

        $sql = "UPDATE tblCategory SET 
                name = ?
                WHERE idCategory = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_name);
        $stmt->bindValue(2, $this->_idCategory);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

    public function returnIdCategory(){
        return $this->_idCategory;
    }

}    