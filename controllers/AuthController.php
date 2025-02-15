<?php
require_once __DIR__."/../services/AuthService.php";
$method = $_SERVER['REQUEST_METHOD'];
http_response_code(200);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$accion = basename($uri);
try{
    if ($accion === 'register' && $method === 'POST'){
        
        $data = decodeJson();
        if (json_last_error() === JSON_ERROR_NONE && isset($data['username']) && isset($data['password'])){
            AuthService::register($data['username'], $data['password']);
            echo json_encode("user registered");
        }else{
            http_response_code(400);
            echo json_encode(["error" => "Not apropiate data"]);
        }
    }elseif ($accion === 'login' && $method === 'POST'){
        $data = decodeJson();
        if (json_last_error() === JSON_ERROR_NONE && isset($data['username']) && isset($data['password'])){
            $token = AuthService::login($data['username'], $data['password']);
            echo json_encode($token);
        }else{
            http_response_code(400);
            echo json_encode(["error" => "Not apropiate data"]);
        }
    }else{
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
    }
}catch(Exception $e){
        http_response_code(500);
        echo json_encode(["error" => "Internal Server Error"]);
    
    
}

function decodeJson(): array{
    $jsonData = file_get_contents("php://input");
    return $data = json_decode($jsonData, true);
}


?>