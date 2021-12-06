<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Database/connection.php');
    include('../Model/ModelAdmin.php');
    include('../Controller/ControllerAdmin.php');

    $conn = new Connection();
    $model = new ModelAdmin($conn->returnConnection());
    $controller = new ControllerAdmin($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);