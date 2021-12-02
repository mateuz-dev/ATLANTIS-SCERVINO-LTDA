<?php

function clearImageFromDiretory($fileName) {
    if ($fileName !== null) {
        unlink("../UploadProduct/" . $fileName);
    }
}

class ModelProduct{

    private $_conn;
    private $_idProduct;
    private $_name;
    private $_price;
    private $_description;
    private $_qtdInventory;
    private $_image1;
    private $_image2;
    private $_image3;
    private $_image4;
    private $_image5;
    private $_image6;
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
        $this->_image1 = $_FILES['image1']['name'] ?? $datasProduct->image1 ?? null;
        $this->_image2 = $_FILES['image2']['name'] ?? $datasProduct->image2 ?? null;
        $this->_image3 = $_FILES['image3']['name'] ?? $datasProduct->image3 ?? null;
        $this->_image4 = $_FILES['image4']['name'] ?? $datasProduct->image4 ?? null;
        $this->_image5 = $_FILES['image5']['name'] ?? $datasProduct->image5 ?? null;
        $this->_image6 = $_FILES['image6']['name'] ?? $datasProduct->image6 ?? null;
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

        function saveImageReturnName($image, $requestName) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $newFileName = md5(microtime()) . ".$extension";
            move_uploaded_file($_FILES[$requestName]['tmp_name'], "../UploadProduct/$newFileName");

            return $newFileName;
        }

        // Manipulação da tabela de produto
        $sql = "INSERT INTO tblProduct (name, price, description, qtdInventory, discount, idColor, idCategory)
        VALUES (?, ?, ?, ?, ?, ?, ?);";

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_name);
        $stm->bindValue(2, $this->_price);
        $stm->bindValue(3, $this->_description);
        $stm->bindValue(4, $this->_qtdInventory);
        $stm->bindValue(5, $this->_discount);
        $stm->bindValue(6, $this->_idColor);
        $stm->bindValue(7, $this->_idCategory);

        $stm->execute();

        //Manipulação das imagens

        //First image
        $nameImage1 = saveImageReturnName($this->_image1, "image1");

        //Second image
        $nameImage2 = saveImageReturnName($this->_image2, "image2");

        //Third image
        $nameImage3 = saveImageReturnName($this->_image3, "image3");

        //Fourth image
        $nameImage4 = saveImageReturnName($this->_image4, "image4");

        //Fifth image
        $nameImage5 = saveImageReturnName($this->_image5, "image5");

        //Sixth image
        $nameImage6 = saveImageReturnName($this->_image6, "image6");

        $lastIdProduct = $this->_conn->lastInsertId();

        //Apenas a imagem 1 é obrigatória
        $sql = "INSERT INTO tblimageproduct (idProduct, image)
            VALUES
            (?, ?)";

            if ($nameImage2 !== null) {
                $sql .= ",($lastIdProduct, '$nameImage2')";
            }
            if ($nameImage3 !== null) {
                $sql .= ",($lastIdProduct, '$nameImage3')";
            }
            if ($nameImage4 !== null) {
                $sql .= ",($lastIdProduct, '$nameImage4')";
            }
            if ($nameImage5 !== null) {
                $sql .= ",($lastIdProduct, '$nameImage5')";
            }
            if ($nameImage6 !== null) {
                $sql .= ",($lastIdProduct, '$nameImage6')";
            }

            $stm = $this->_conn->prepare($sql);

            $stm->bindValue(1, $lastIdProduct);
            $stm->bindValue(2, $nameImage1);

            $stm->execute();

    }

    public function delete(){

        //Deletar imagem da pasta
        $sql = "SELECT image FROM tblImageProduct, tblProduct WHERE tblProduct.idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);
        $stmt->execute();

        if ($stmt->execute()) {
            $filesName = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //APAGANDO A PRIMEIRA IMAGEM
            unlink("../UploadProduct/" . $filesName[0]['image']);

            //VERIFICANDO SE HÁ, E APAGANDO IMAGENS RESTANTES.
            clearImageFromDiretory($filesName[1]['image']);
            clearImageFromDiretory($filesName[2]['image']);
            clearImageFromDiretory($filesName[3]['image']);
            clearImageFromDiretory($filesName[4]['image']);
            clearImageFromDiretory($filesName[5]['image']);
        }

        //DELETE ImageProduct in SQL
        $sql = "DELETE FROM tblImageProduct WHERE idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);

        $stmt->execute();

        //Delete product in SQL
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

        //Deletar imagem da pasta
        $sql = "SELECT image FROM tblImageProduct, tblProduct WHERE tblProduct.idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);
        $stmt->execute();

        if ($stmt->execute()) {
            $filesName = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //APAGANDO A PRIMEIRA IMAGEM
            unlink("../UploadProduct/" . $filesName[0]['image']);

            //VERIFICANDO SE HÁ, E APAGANDO IMAGENS RESTANTES.
            clearImageFromDiretory($filesName[1]['image']);
            clearImageFromDiretory($filesName[2]['image']);
            clearImageFromDiretory($filesName[3]['image']);
            clearImageFromDiretory($filesName[4]['image']);
            clearImageFromDiretory($filesName[5]['image']);
        }

        //DELETE ImageProduct in SQL
        $sql = "DELETE FROM tblImageProduct WHERE idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);

        $stmt->execute();

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