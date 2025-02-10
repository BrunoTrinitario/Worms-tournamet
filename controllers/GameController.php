<?php
require_once __DIR__."/../services/GameService.php";
require_once __DIR__."/../util/GameException.php";

$method = $_SERVER['REQUEST_METHOD'];
http_response_code(200);
try{
    switch($method){
        case "GET":
            if (empty($_GET)){
                $games = GameService::getAllGames();
                echo json_encode($games);
            }
            elseif (isset($_GET['id'])){
                $game = GameService::getGameById($_GET['id']);
                echo json_encode($game);
            }elseif (isset($_GET['date'])){
                $game = GameService::getGamesByDate($_GET['date']);
                echo json_encode($game);
            }elseif($_GET['date1'] && $_GET['date2']){
                $game = GameService::getGamesBetweenDates($_GET['date1'],$_GET['date2']);
                echo json_encode($game);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "POST":
            $data = decodeJson();
            if (json_last_error() === JSON_ERROR_NONE && isset($data['date']) && isset($data['description'])){
                $game = GameService::saveGame(new Game(null, $data['date'], $data['description']));
                echo json_encode($game);
            }else{
                http_response_code(400);
                echo json_encode(["error" => "Not apropiate data"]);
            }
            break;
        case "DELETE":
            if (isset($_GET['id'])){
                GameService::deleteGameById($_GET['id']);
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
catch(GameException $e){
    http_response_code(400);
    echo json_encode($e->getMessage());
}

function decodeJson(): array{
    $jsonData = file_get_contents("php://input");
    return $data = json_decode($jsonData, true);
}

?>