<?php
    require_once __DIR__ . "/config/SecurityFilters.php";
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");


    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
    
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    http_response_code(200);

    $extensiones_permitidas = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'otf'];

    $extension = pathinfo($request_uri, PATHINFO_EXTENSION);

    if (in_array($extension, $extensiones_permitidas)) {
        return false;
    }
        
    $controllers = ["","AuthController.php", "GameController.php", "PersonController.php", "PersonGameController.php"];

    $paths = ["/index", "/auth", "/games", "/persons", "/points"];

    if ($request_uri === '/' || $request_uri === '/login') {
        readfile(__DIR__."/frontend/login.html");
        exit;
    }

    if (strpos($request_uri, "/auth")===0){
        require __DIR__."/./controllers/".$controllers[1];
        exit;
    }

    if (getallheaders()["Authorization"] && SecurityFilters::JWTfilter(getallheaders()["Authorization"])) {
        $token = getallheaders()["Authorization"];
        $token = str_replace("Bearer ", "", $token);
        $i=0;
        foreach ($paths as $path) {
            if (strpos($request_uri, $path) === 0) {
                if ($path === "/index") {
                    if (SecurityFilters::roleFilter($token)) {
                        readfile(__DIR__."/frontend/index.html");
                        exit;
                    }else{
                        readfile(__DIR__."/frontend/user_index.html");
                        exit;
                    }
                }else{
                    require __DIR__."/./controllers/".$controllers[$i];
                    exit;
                }
                exit;
            }
            $i++;
        }
    }else{
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
        exit;
    }

    http_response_code(404);
    echo json_encode(["error" => "Not found"]);

   




?>