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
    private $_mainImage;
    private $_optionalImages;


    public function __construct($conn){
        $json = file_get_contents("php://input");
        $datasProduct = json_decode($json);

        $this->_idProduct = $_REQUEST['idProduct'] ?? $datasProduct->idProduct ??  null;
        $this->_name = $_POST['name'] ?? $datasProduct->name ?? null;
        $this->_price = $_POST['price'] ?? $datasProduct->price ?? null;
        $this->_description = $_POST['description'] ?? $datasProduct->description ?? null;
        $this->_qtdInventory = $_POST['qtdInventory'] ?? $datasProduct->qtdInventory ?? null;
        $this->_mainImage = $_FILES['image1'] ?? $datasProduct->image1 ?? null;

        $this->_optionalImages = [
        $_FILES['image2'] ?? $datasProduct->image2 ?? null,
        $_FILES['image3'] ?? $datasProduct->image3 ?? null,
        $_FILES['image4'] ?? $datasProduct->image4 ?? null,
        $_FILES['image5'] ?? $datasProduct->image5 ?? null,
        $_FILES['image6'] ?? $datasProduct->image6 ?? null,
        ];
    
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

        function saveImageReturnName($imageDatas) {
            $extension = pathinfo($imageDatas['name'], PATHINFO_EXTENSION);
            $newFileName = md5(microtime()) . ".$extension";
            move_uploaded_file($imageDatas['tmp_name'], "../UploadProduct/$newFileName");

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

        //Main image
        $mainImageName = saveImageReturnName($this->_mainImage);
        $this->_mainImage['dataBaseName'] = $mainImageName;
        // exit(var_dump($mainImageName));

        //Optional images
        foreach ($this->_optionalImages as $key => $optionalImage) {
            $nameImage = saveImageReturnName($optionalImage);
            $this->_optionalImages[$key]['dataBaseName'] = $nameImage;
        }

        // exit(var_dump($this->_optionalImages));

        $lastIdProduct = $this->_conn->lastInsertId();

        //Apenas a imagem 1 é obrigatória
        $sql = "INSERT INTO tblimageproduct (idProduct, image)
            VALUES
            (?, ?)";

        foreach ($this->_optionalImages as $key => $optionalImage) {
            $imageName = $optionalImage['dataBaseName'];
            if ($imageName !== null) {
                $sql .= ",($lastIdProduct, '$imageName')";
            }
        }

            $stm = $this->_conn->prepare($sql);

            $stm->bindValue(1, $lastIdProduct);
            $stm->bindValue(2, $mainImageName);

            $stm->execute();

    }

    public function delete(){

        //Deletar imagem da pasta
        $sql = "SELECT image FROM tblImageProduct WHERE idProduct = ?";
        $stmt = $this->_conn->prepare($sql);
        $stmt->bindValue(1, $this->_idProduct);
        $stmt->execute();

        if ($stmt->execute()) {
            $filesName = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //APAGANDO A PRIMEIRA IMAGEM
            unlink("../UploadProduct/" . $this->_mainImage['dataBaseName']);

            //VERIFICANDO SE HÁ, E APAGANDO IMAGENS RESTANTES.
            foreach ($this->_optionalImages as $key => $optionalImage) {
                clearImageFromDiretory($optionalImage['dataBaseName']);
            }
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