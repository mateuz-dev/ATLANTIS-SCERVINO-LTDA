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
        $this->_icon = $_FILES['icon']['name'] ?? $datasCategory->icon ?? null;
        $this->_backgroundImage = $_FILES['backgroundImage']['name'] ?? $datasCategory->backgroundImage ?? null;

        $this->_conn = $conn;

    }

    public function findAll(){

        $sql = "SELECT * FROM tblCategory";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    
    }

    public function create(){
        $sql = "INSERT INTO tblCategory (name, icon, backgroundImage)
                VALUES (?, ?, ?)";

                $extension = pathinfo($this->_icon, PATHINFO_EXTENSION);
                $newIconName = md5(microtime()) . ".$extension";
                $newBackgroundName = md5(microtime()) . ".$extension";
                move_uploaded_file($_FILES['icon']['tmp_name'], "../UploadCategory/icon/$newIconName");
                move_uploaded_file($_FILES['backgroundImage']['tmp_name'], "../UploadCategory/background/$newBackgroundName");

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_name);
        $stm->bindValue(2, $newIconName);
        $stm->bindValue(3, $newBackgroundName);

        if ($stm->execute()){
            return "Sucess";
        } else {
            return "Error";
        }
    }

    public function delete(){

        //Deletar imagem da pasta
        $sql = "SELECT icon FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        if ($stm->execute()) {
            $IconName = $stm->fetchAll()[0]['icon'];
            unlink("../UploadCategory/icon/" . $IconName);

        }


        $sql = "SELECT backgroundImage FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        if ($stm->execute()) {
            $BackgroundName = $stm->fetchAll()[0]['backgroundImage'];
            unlink("../UploadCategory/background/" . $BackgroundName);
        }

        //Deletar categoria no sql

        $sql = "DELETE FROM tblCategory WHERE idCategory = ?";

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_idCategory);

        if ($stm->execute()) {
            return "Dados excluídos com sucesso!";
        } else {
            return "Erro";
        }

    }

    public function update(){
      
        $sql = "SELECT icon FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        if ($stm->execute()) {
            $IconName = $stm->fetchAll()[0]['icon'];
            unlink("../UploadCategory/icon/" . $IconName);
        }

        $sql = "SELECT backgroundImage FROM tblCategory WHERE idCategory = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        if ($stm->execute()) {
            $BackgroundName = $stm->fetchAll()[0]['backgroundImage'];
            unlink("../UploadCategory/background/" . $BackgroundName);
        }

        $sql = "UPDATE tblCategory SET 
                name = ?,
                icon = ?,
                backgroundImage = ?
                WHERE idCategory = ?";

        $extension = pathinfo($this->_icon, PATHINFO_EXTENSION);
        $iconName = md5(microtime()) . ".$extension";
        $path = "../UploadCategory/icon/" . $iconName;
        move_uploaded_file($_FILES["icon"]["tmp_name"], $path);

        $extension = pathinfo($this->_backgroundImage, PATHINFO_EXTENSION);
        $backgroundName = md5(microtime()) . ".$extension";
        $path = "../UploadCategory/background/" . $backgroundName;
        move_uploaded_file($_FILES["backgroundImage"]["tmp_name"], $path);

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_name);
        $stmt->bindValue(2, $iconName);
        $stmt->bindValue(3, $backgroundName);
        $stmt->bindValue(4, $this->_idCategory);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

        public function returnIdCategory(){
            return $this->_idCategory;
        }

}    