<?php

class ModelColor{
    public function __construct($conn){
        $this->_conn = $conn;
    }

    public function findAll(){
        $sql = "SELECT * FROM tblColor";

        $stm = $this->_conn->prepare($sql);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>