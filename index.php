<?php
    require_once __DIR__ . "/config/SecurityFilters.php";
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
    
    if( strpos($uri, '/login')  === 0){
        require __DIR__ . "/frontend/login.html";
    }elseif( strpos($uri, '/auth')  === 0 ){
        require __DIR__ . "/controllers/AuthController.php";
    }else{
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth_header = $_SERVER['HTTP_AUTHORIZATION'];
            if (SecurityFilters::JWTfilter($auth_header)){
                if ( strpos($uri, '/person')  === 0 ){
                    require __DIR__ . "/controllers/PersonController.php";
                    exit();
               }elseif( strpos($uri, '/game')  === 0 ){
                   require __DIR__ . "/controllers/GameController.php";
                   exit();
               }elseif( strpos($uri, '/points')  === 0 ){
                   require __DIR__ . "/controllers/PersonGameController.php";
                   exit();
               }else{
                   http_response_code(404);
                   echo json_encode(["error" => "Not Found"]);
               }
            }else{
                http_response_code(401);
                exit();
            }
            
        }else{
            http_response_code(401);
            exit();
        }
        
    }



?>