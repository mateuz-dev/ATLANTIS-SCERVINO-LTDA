<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Database/connection.php');
    include('../Model/ModelColor.php');
    include('../Controller/ControllerColor.php');

    $conn = new Connection();
    $model = new ModelColor($conn->returnConnection());
    $controller = new ControllerColor($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);