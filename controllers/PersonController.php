<?php
require_once __DIR__."/../services/PersonService.php";
require_once __DIR__."/../util/PersonException.php";

$method = $_SERVER['REQUEST_METHOD'];
http_response_code(200);
try{
    switch($method){
        case "GET":
            if (empty($_GET)){
                $persons = PersonService::getAllPersons();
                echo json_encode($persons);
            }
            elseif (isset($_GET['id'])){
                $person = PersonService::findById($_GET['id']);
                echo json_encode($person);
            }elseif (isset($_GET['nick'])){
                $person = PersonService::findByNick($_GET['nick']);
                echo json_encode($person);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "POST":
            $data = decodeJson();
            if (json_last_error() === JSON_ERROR_NONE && isset($data['nick'])){
                $person = new Person(null,$data['nick']);
                $person = PersonService::savePerson($person);
                echo json_encode($person);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "PATCH":
            if (json_last_error() === JSON_ERROR_NONE && isset($_GET['nick']) && isset($_GET['id'])){
                $person = PersonService::updatePersonById($_GET['id'], $_GET['nick']);
                echo json_encode($person);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "DELETE":
            if (isset($_GET['id'])){
                PersonService::deleteById($_GET['id']);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Not Found"]);
            break;
    }
}
catch(PersonException $e){
    http_response_code(400);
    echo json_encode($e->getMessage());
}

function decodeJson(): array{
    $jsonData = file_get_contents("php://input");
    return json_decode($jsonData, true);
}


?>