<?php
require_once __DIR__."/../services/PersonGameService.php";
require_once __DIR__."/../util/PersonGameException.php";
require_once __DIR__."/../dtos/NewPersonGameDto.php";
$method = $_SERVER['REQUEST_METHOD'];
http_response_code(200);
try{
    switch($method){
        case "GET":
            if (empty($_GET)){
                $games = PersonGameService::getAllGames();
                echo json_encode($games);
            }elseif(isset($_GET['user'])){
                $games = PersonGameService::getAllInfomationGameForUsers();
                echo json_encode($games);
            }elseif (isset($_GET['user-id'])){
                $game = PersonGameService::getAllInfomationGameForOneUser($_GET['user-id']);
                echo json_encode($game);
            }elseif(isset($_GET['game-id'])){
                $game = PersonGameService::getAllInfomationGameForGame($_GET['game-id']);
                echo json_encode($game);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "POST":
            $data = decodeJson();
            if (validateData($data)){
                $personGameDto = new NewPersonGameDto($data['person_id'],$data['game_id'],$data['game_points'],$data['mvp_points'],$data['damage_points'],$data['quantity_points']);
                $game = PersonGameService::createPersonGame($personGameDto);
                echo json_encode($game);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "DELETE":
            if (isset($_GET['person_id']) && isset($_GET['game_id'])){
                PersonGameService::deleteById($_GET['person_id'],$_GET['game_id']);
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
}catch(PersonGameException $e){
    http_response_code(400);
    echo json_encode($e->getMessage());
}

function decodeJson(): array{
    $jsonData = file_get_contents("php://input");
    return $data = json_decode($jsonData, true);
}

function validateData($data){
    if (json_last_error() === JSON_ERROR_NONE && isset($data['person_id']) && isset($data['game_id']) && isset($data['game_points']) && isset($data['mvp_points']) && isset($data['damage_points']) && isset($data['quantity_points'])){
        return true;
    }else{
        return false;
    }
}       

?>