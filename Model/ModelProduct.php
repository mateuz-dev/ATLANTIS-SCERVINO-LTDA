<?php

class ModelProduct{

    private $_conn;
    private $_codProduct;
    private $_name;
    private $_price;
    private $_description;
    private $_qtdInventory;
    private $_image;
    private $_discount;
    private $_color;

    public function __construct($conn){

        //PERMITE RECEBER DADOS JSON ATRAVÉS DA REQUISIÇÃO.
        $json = file_get_contents("php://input");
        $dadosPessoa = json_decode($json);

        //RECEBIMENTO DOS DADOS VIA POST OU JSON

        $this->_codPessoa = $_REQUEST['cod_pessoa'] ?? $dadosPessoa->cod_pessoa ??  null;
        $this->_nome = $_POST['nome'] ?? $dadosPessoa->nome ?? null;
        $this->_sobrenome = $_POST['sobrenome'] ?? $dadosPessoa->sobrenome ?? null;
        $this->_email = $_POST['email'] ?? $dadosPessoa->email ?? null;
        $this->_celular = $_POST['celular'] ?? $dadosPessoa->celular ?? null;
        $this->_fotografia = $_FILES['fotografia']['name'] ?? $dadosPessoa->fotografia ?? null;

        $this->_conn = $conn;
    }

    public function findAll(){
        //Monta a instrução SQL
        $sql = "SELECT * FROM tbl_pessoa";

        //Prepara um processo de execução de instrução SQL
        $stm = $this->_conn->prepare($sql);
        //Executa instrução sql
        $stm->execute();

        //Devolve os valores da select para serem utilizados
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(){

        $sql = "SELECT * FROM tbl_pessoa WHERE cod_pessoa = ?";
        $stm = $this->_conn->prepare($sql);
        $stm->bindValue(1, $this->_codPessoa);
        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function create(){
        $sql = "INSERT INTO tbl_pessoa (nome, sobrenome, email, celular, fotografia)
                VALUES (?, ?, ?, ?, ?)";

                $extensao = pathinfo($this->_fotografia, PATHINFO_EXTENSION);
                $novoNomeArquivo = md5(microtime()) . ".$extensao";
                move_uploaded_file($_FILES['fotografia']['tmp_name'], "../upload/$novoNomeArquivo");

        $stm = $this->_conn->prepare($sql);

        $stm->bindValue(1, $this->_nome);
        $stm->bindValue(2, $this->_sobrenome);
        $stm->bindValue(3, $this->_email);
        $stm->bindValue(4, $this->_celular);
        $stm->bindValue(5, $novoNomeArquivo);

        if ($stm->execute()){
            return "Sucelso";
        } else {
            return "Erro";
        }
    }

    public function delete(){

        $sql = "DELETE FROM tbl_pessoa WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados excluídos com sucesso!";
        } else {
            return "Erro";
        }

    }

    public function update(){

        $sql = "UPDATE tbl_pessoa SET 
        nome = ?,
        sobrenome = ?,
        email = ?,
        celular = ?,
        fotografia = ?
        WHERE cod_pessoa = ?";

        $stmt = $this->_conn->prepare($sql);

        $stmt->bindValue(1, $this->_nome);
        $stmt->bindValue(2, $this->_sobrenome);
        $stmt->bindValue(3, $this->_email);
        $stmt->bindValue(4, $this->_celular);
        $stmt->bindValue(5, $this->_fotografia);
        $stmt->bindValue(6, $this->_codPessoa);

        if ($stmt->execute()) {
            return "Dados alterados com sucesso!";
        }

    }

}

?>