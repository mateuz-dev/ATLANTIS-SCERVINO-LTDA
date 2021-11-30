<?php

class Connection{

    private $_dbHostName = "127.0.0.1";
    private $_dbName = "dbScervino";
    private $_userName = "root";
    private $_dbPassword = "bcd127";
    private $_conn;

    public function __construct()
    {
        try {

            $this->_conn = new PDO("mysql:host=$this->_dbHostName;dbname=$this->_dbName;", 
            $this->_userName,
            $this->_dbPassword);

            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch (PDOException $error) {
            echo 'Connection error' . $error->getMessage();
        }
    }

    public function returnConnection(){
        return $this->_conn;
    }

}

?>