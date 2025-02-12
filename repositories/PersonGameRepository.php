<?php
require_once __DIR__."/../models/PersonGame.php";
require_once __DIR__."/../dtos/PersonPointDto.php";
class PersonGameRepository {
    public static function createPersonGame(PersonGame $personGame): PersonGame {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            INSERT INTO persongame (
                person_id, 
                game_id, 
                points, 
                mvp_points, 
                damage_points, 
                quantity_points
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $personGame->person->id,
            $personGame->game->id,
            $personGame->game_points,
            $personGame->mvp_points,
            $personGame->damage_points,
            $personGame->quantity_points
        ]);
        $personGame->id = $pdo->lastInsertId();
        return $personGame;
    }

    public static function deleteById($person_id, $game_id): void {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM persongame WHERE person_id  = ? and game_id =  ? ");
        $stmt->execute([$person_id, $game_id]);
    }

    public static function getAllInfomationGameForUsers(): array{
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT person_id,
        nick, 
        count(*) as games, 
        sum(points) as tot_points,
        sum(mvp_points) as tot_mvp_points,
        sum(damage_points) as tot_dmg_points,
        sum(quantity_points) as tot_qua_points
        FROM persongame, person 
        where persongame.person_id = person.id
        GROUP BY person_id
        "
        );
        $stmt->execute();
        $PersonPointArray=[];
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $element){
            $PersonPointArray[] = new PersonPointDto($element['person_id'],$element['nick'],$element['tot_points'],$element['tot_mvp_points'],$element['tot_dmg_points'],$element['tot_qua_points'],$element['games']);
        }
        return $PersonPointArray;
    }

    public static function getAllInfomationGameForOneUser($id) : ?PersonPointDto{
        $array = PersonGameRepository::getAllInfomationGameForUsers();
        $aux = [];
        foreach ($array as $persongame){
            if ($persongame -> person_id == $id){
                return $persongame;
            }
        }
        return null;
    }

    public static function getAllGames(): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT persongame.*, nick FROM persongame, person where persongame.person_id = person.id");
        $stmt->execute();
        $PersonPointArray=[];
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $element){
            $PersonPointArray[] = new PersonPointDto($element['game_id'],$element['nick'],$element['points'],$element['mvp_points'],$element['damage_points'],$element['quantity_points'],1);
        }
        return $PersonPointArray;
    }

    public static function getAllInfomationGameForOneGame($game_id): array{
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT persongame.*, nick FROM persongame, person where persongame.game_id  = ? and persongame.person_id = person.id");
        $stmt->execute([$game_id]);
        $PersonPointArray=[];
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $element){
            $PersonPointArray[] = new PersonPointDto($element['game_id'],$element['nick'],$element['points'],$element['mvp_points'],$element['damage_points'],$element['quantity_points'],1);
        }
        return $PersonPointArray;
    }

}
?>