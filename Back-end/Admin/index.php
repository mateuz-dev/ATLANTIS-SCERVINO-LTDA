<?php
    header('Acess-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Headers: *');
    header('Acess-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Connection.php');
    include('../Model/ModelAdmin.php');
    include('../Controller/ControllerAdmin.php');

    $conn = new Connection();
    $model = new ModelAdmin($conn->returnConnection());
    $controller = new ControllerAdmin($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);