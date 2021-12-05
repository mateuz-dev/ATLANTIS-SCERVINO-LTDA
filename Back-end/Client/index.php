<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Connection.php');
    include('../Model/ModelClient.php');
    include('../Controller/ControllerClient.php');

    $conn = new Connection();
    $model = new ModelClient($conn->returnConnection());
    $controller = new ControllerClient($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);