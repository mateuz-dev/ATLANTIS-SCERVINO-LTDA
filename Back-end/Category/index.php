<?php
    header('Acess-Control-Allow-Origin: *');
    header('Access-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Headers: *');
    header('Acess-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Connection.php');
    include('../Model/ModelCategory.php');
    include('../Controller/ControllerCategory.php');

    $conn = new Connection();
    $model = new ModelCategory($conn->returnConnection());
    $controller = new ControllerCategory($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);