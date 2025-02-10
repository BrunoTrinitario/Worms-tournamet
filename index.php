<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
    
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    http_response_code(200);
    
    if ( strpos($uri, '/person')  === 0 ){
         require __DIR__ . "/controllers/PersonController.php";
    }elseif( strpos($uri, '/game')  === 0 ){
        require __DIR__ . "/controllers/GameController.php";
    }elseif( strpos($uri, '/points')  === 0 ){
        require __DIR__ . "/controllers/PersonGameController.php";
    }elseif ( strpos($uri, '/index')  === 0){
        require __DIR__ . "/frontend/index.html";
    }else{
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
    }



?>