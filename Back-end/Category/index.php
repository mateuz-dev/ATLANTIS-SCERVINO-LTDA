<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Database/connection.php');
    include('../Model/ModelCategory.php');
    include('../Controller/ControllerCategory.php');

    $conn = new Connection();
    $model = new ModelCategory($conn->returnConnection());
    $controller = new ControllerCategory($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);