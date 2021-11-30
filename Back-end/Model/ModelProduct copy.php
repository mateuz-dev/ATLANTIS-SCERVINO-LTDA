<?php

class ModelProduct{

    private $_conn;
    private $_idProduct;
    private $_name;
    private $_price;
    private $_description;
    private $_qtdInventory;
    private $_image;
    private $_discount;
    private $_idCategory;
    private $_idColor;

    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasProduct = json_decode($json);

        $this->_idProduct = $_REQUEST['idProduct'] ?? $datasProduct->idProduct ??  null;
        $this->_name = $_POST['name'] ?? $datasProduct->name ?? null;
        $this->_price = $_POST['price'] ?? $datasProduct->price ?? null;
        $this->_description = $_POST['description'] ?? $datasProduct->description ?? null;
        $this->_qtdInventory = $_POST['qtdInventory'] ?? $datasProduct->qtdInventory ?? null;
        $this->_image = $_FILES['image']['name'] ?? $datasProduct->image ?? null;
        $this->_discount = $_POST['discount'] ?? $datasProduct->discount ?? null;
        $this->_idCategory = $_POST['idCategory'] ?? $datasProduct->idCategory ?? null;
        $this->_idColor = $_POST['idColor'] ?? $datasProduct->idColor ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){
        $sql = "SELECT * FROM tblProduct";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(){

        $sql = "SELECT * FROM tblProduct WHERE idProduct = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idProduct);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function create(){
        $sql = "INSERT INTO tblProduct (name, price, description, qtdInventory, image, discount, idCategory, idColor)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $extension = pathinfo($this->_image, PATHINFO_EXTENSION);
                $newFileName = md5(microtime()) . ".$extension";
                move_uploaded_file($_FILES['image']['tmp_name'], "../Upload/$newFileName");

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_name);
        $stm->bindValue(2, $this->_price);
        $stm->bindValue(3, $this->_description);
        $stm->bindValue(4, $this->_qtdInventory);
        $stm->bindValue(5, $newFileName);
        $stm->bindValue(6, $this->_discount);
        $stm->bindValue(7, $this->_idCategory);
        $stm->bindValue(8, $this->_idColor);

        if ($stm->execute()){
            return "Sucess";
        } else {
            return "Error";
        }
    }

    public function delete(){

        //Deletar imagem da pasta
        $sql = "SELECT image FROM tblProduct WHERE idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);
        $stmt->execute();

        if ($stmt->execute()) {
            $fileName = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['image'];
            unlink("../Upload/" . $fileName);
        }

        //Deletar produto no sql

        $sql = "DELETE FROM tblProduct WHERE idProduct = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_idProduct);

        if ($stmt->execute()) {
            return "Dados excluídos com sucesso!";
        } else {
            return "Erro";
        }

    }

    public function update(){

        $sql = "UPDATE tblProduct SET 
        name = ?,
        price = ?,
        description = ?,
        qtdInventory = ?,
        image = ?,
        discount = ?,
        idCategory = ?,
        idColor = ?
        WHERE idProduct = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_name);
        $stmt->bindValue(2, $this->_price);
        $stmt->bindValue(3, $this->_description);
        $stmt->bindValue(4, $this->_qtdInventory);
        $stmt->bindValue(5, $this->_image);
        $stmt->bindValue(6, $this->_discount);
        $stmt->bindValue(7, $this->_idCategory);
        $stmt->bindValue(8, $this->_idColor);
        $stmt->bindValue(9, $this->_idProduct);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

}

?>