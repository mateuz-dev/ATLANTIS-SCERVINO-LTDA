<?php

    header('Acess-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Headers: *');
    header('Acess-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Content-Type: application/json');

    include('../Connection.php');
    include('../Model/ModelClient.php');
    include('../Controller/ControllerClient.php');

    $conn = new Connection();
    $model = new ModelClient($conn->returnConnection());
    $controller = new ControllerClient($model);

    echo json_encode(["status"=>"Sucess", "data"=>$controller->router()]);