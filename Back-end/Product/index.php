<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Database/connection.php');
    include('../Model/ModelProduct.php');
    include('../Controller/ControllerProduct.php');

    $conn = new Connection();
    $model = new ModelProduct($conn->returnConnection());
    $controller = new ControllerProduct($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);