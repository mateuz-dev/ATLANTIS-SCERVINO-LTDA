<?php

    header('Acess-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Headers: *');
    header('Acess-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Connection.php');
    include('../Model/ModelProduct.php');
    include('../Controller/ControllerProduct.php');

    $conn = new Connection();
    $model = new ModelProduct($conn->returnConnection());
    $controller = new ControllerProduct($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);