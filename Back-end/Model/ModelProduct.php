<?php

function saveImageReturnName($imageDatas) {
    if ($imageDatas['tmp_name'] !== null &&
    $imageDatas['tmp_name'] !== "") {
        $extension = pathinfo($imageDatas['name'], PATHINFO_EXTENSION);
        $newFileName = md5(microtime()) . ".$extension";
        move_uploaded_file($imageDatas['tmp_name'], "../Uploads/UploadProduct/$newFileName");
        return $newFileName;
    }
}

class ModelProduct{

    private $_conn;
    private $_idProduct;
    private $_name;
    private $_price;
    private $_description;
    private $_qtdInventory;
    private $_mainImage;
    private $_optionalImages;
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
        $this->_mainImage = $_FILES['image1'] ?? null;

        $this->_optionalImages = [
            $_FILES['image2'] ?? null,
            $_FILES['image3'] ?? null,
            $_FILES['image4'] ?? null,
            $_FILES['image5'] ?? null,
            $_FILES['image6'] ?? null,
        ];
    
        $this->_discount = $_POST['discount'] ?? $datasProduct->discount ?? null;
        $this->_idCategory = $_REQUEST['idCategory'] ?? $datasProduct->idCategory ?? null;
        $this->_idColor = $_POST['idColor'] ?? $datasProduct->idColor ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){
        $sql = "SELECT tblProduct.idProduct, tblProduct.name AS nameProduct, tblProduct.price, 
                tblProduct.description, tblProduct.qtdInventory, 
                tblProduct.discount, tblColor.idColor, tblColor.name AS nameColor,
                tblColor.hexa, tblCategory.idCategory, tblCategory.name AS nameCategory, 
                tblImageProduct.image
                FROM tblProduct 
                INNER JOIN tblColor ON tblProduct.idColor = tblcolor.idColor
                INNER JOIN tblCategory ON tblProduct.idCategory = tblCategory.idCategory
                INNER JOIN tblImageProduct ON tblProduct.idProduct = tblImageProduct.idProduct";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(){

        $sql = "SELECT tblProduct.idProduct, 
                tblProduct.name AS nameProduct, tblProduct.price, 
                tblProduct.description, tblProduct.qtdInventory, 
                tblProduct.discount, tblColor.name AS nameColor,
                tblColor.hexa, tblColor.idColor,
                tblCategory.name AS nameCategory, 
                tblCategory.idCategory, tblImageProduct.image
                FROM tblProduct 
                INNER JOIN tblColor ON tblProduct.idColor = tblcolor.idColor
                INNER JOIN tblCategory ON tblProduct.idCategory = tblCategory.idCategory
                INNER JOIN tblImageProduct ON tblProduct.idProduct = tblImageProduct.idProduct
                WHERE tblProduct.idProduct = ?";

        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idProduct);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function findByCategoryId(){

        $sql = "SELECT tblProduct.idProduct,
                tblProduct.name AS nameProduct, tblProduct.price, 
                tblProduct.description, tblProduct.qtdInventory, 
                tblProduct.discount, tblColor.name AS nameColor,
                tblColor.hexa, tblCategory.name AS nameCategory, 
                tblImageProduct.image
                FROM tblProduct 
                INNER JOIN tblColor ON tblProduct.idColor = tblcolor.idColor
                INNER JOIN tblCategory ON tblProduct.idCategory = tblCategory.idCategory
                INNER JOIN tblImageProduct ON tblProduct.idProduct = tblImageProduct.idProduct
                WHERE tblCategory.idCategory = ?";

        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idCategory);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(){

        // Manipula????o da tabela de produto
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

        if ($stm->execute()) {
            //Manipula????o das imagens

        //Main image
        $mainImageName = saveImageReturnName($this->_mainImage);
        $this->_mainImage['dataBaseName'] = $mainImageName;

        //Optional images
        foreach ($this->_optionalImages as $key => $optionalImage) {
            $nameImage = saveImageReturnName($optionalImage);

            $this->_optionalImages[$key]['dataBaseName'] = $nameImage;
        }

        $lastIdProduct = $this->_conn->lastInsertId();

        //Apenas a imagem 1 ?? obrigat??ria
        $sql = "INSERT INTO tblimageproduct (idProduct, image)
            VALUES
            (?, ?)";

        foreach ($this->_optionalImages as $key => $optionalImage) {
            $imageName = $optionalImage['dataBaseName'];

            if ($imageName !== null &&
            $imageName !== "") {

                $sql .= ",($lastIdProduct, '$imageName')";
            }
        }

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $lastIdProduct);
        $stm->bindValue(2, $mainImageName);

        $stm->execute();
        };

    }

    public function delete(){
        $sql = "SELECT image FROM tblImageProduct WHERE idProduct = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_idProduct);
        $stm->execute();
        $AllImages = $stm->fetchAll(PDO::FETCH_ASSOC);

        foreach ($AllImages as $key => $image) {
            $imageName = $image['image'];
            unlink("../Uploads/UploadProduct/$imageName");
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
        
        $stmt->execute();

    }

    public function update(){

        //EM CASO DE ALTERA????O DE IMAGEM, TODAS ELAS SER??O EXCLU??DAS E SOBREPOSTAS.
        if ($this->_mainImage['name'] !== null &&
            $this->_mainImage['name'] !== "") {
            $sql = "SELECT image FROM tblImageProduct WHERE idProduct = ?";
            $stm = $this->_conn->prepare($sql);
            $stm->bindValue(1, $this->_idProduct);
            $stm->execute();
            $AllImages = $stm->fetchAll(PDO::FETCH_ASSOC);

            foreach ($AllImages as $key => $image) {
                $imageName = $image['image'];
                unlink("../Uploads/UploadProduct/$imageName");
            }

            //DELETE ImageProduct in SQL
            $sql = "DELETE FROM tblImageProduct WHERE idProduct = ?";
            $stmt = $this->_conn->prepare($sql);
            $stmt->bindValue(1, $this->_idProduct);
            $stmt->execute();

            //CRIA????O DAS NOVAS IMAGENS
            //Main image
            $mainImageName = saveImageReturnName($this->_mainImage);
            $this->_mainImage['dataBaseName'] = $mainImageName;

            //Optional images
            foreach ($this->_optionalImages as $key => $optionalImage) {
                if (isset($optionalImage['name']) &&
                    $optionalImage['name'] !== '') {
                    $nameImage = saveImageReturnName($optionalImage);
                    $this->_optionalImages[$key]['dataBaseName'] = $nameImage;
                }
            }

            //Apenas a imagem 1 ?? obrigat??ria
            $sql = "INSERT INTO tblimageproduct (idProduct, image)
                VALUES
                (?, ?)";

            foreach ($this->_optionalImages as $key => $optionalImage) {
                $imageName = $optionalImage['dataBaseName'];
                if ($imageName !== null &&
                $imageName !== '') {
                    $sql .= ",($this->_idProduct, '$imageName')";
                }
            }

            $stm = $this->_conn->prepare($sql);

            $stm->bindValue(1, $this->_idProduct);
            $stm->bindValue(2, $this->_mainImage['dataBaseName']);
            
            $stm->execute();
        }

        $sql = "UPDATE tblProduct SET 
        name = ?,
        price = ?,
        description = ?,
        qtdInventory = ?,
        discount = ?,
        idCategory = ?,
        idColor = ?
        WHERE idProduct = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_name);
        $stmt->bindValue(2, $this->_price);
        $stmt->bindValue(3, $this->_description);
        $stmt->bindValue(4, $this->_qtdInventory);
        $stmt->bindValue(5, $this->_discount);
        $stmt->bindValue(6, $this->_idCategory);
        $stmt->bindValue(7, $this->_idColor);
        $stmt->bindValue(8, $this->_idProduct);

        $stmt->execute();
    }

    public function returnIdProduct(){
        return $this->_idProduct;
    }

    public function returnIdCategory(){
        return $this->_idCategory;
    }
}

?>