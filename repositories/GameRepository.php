<?php
require_once __DIR__."/../models/Game.php";
require_once __DIR__."/../models/GameData.php";
require_once __DIR__."/../dtos/DataGameDto.php";
require_once __DIR__."/../config/db_utilities.php";
class GameRepository {
    public static function save(Game $game): Game {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO game (game_date,description) VALUES (?,?)");
        $stmt->execute([$game->date, $game->description]);
        $game->id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO game_data (game_id) VALUES (?)");
        $stmt->execute([$game->id]);
        return $game;
    }


    public static function findById($id): ?Game {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM game WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Game($data['id'], $data['game_date'], $data['description']);
        }else{
            return null;
        }
    }

    public static function findByDate($date): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM game WHERE game_date = ?");
        $stmt->execute([$date]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($g) => new Game($g['id'], $g['game_date'], $g['description']), $data);
    }

    public static function findAll(): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM game");
        $stmt->execute([]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($g) => new Game($g['id'], $g['game_date'], $g['description']), $data);
    }

    public static function deleteById($id): void {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("DELETE FROM game WHERE id = ?");
            $stmt->execute([$id]);
    }

    public static function findBetweenDates($startDate, $endDate): array {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM game WHERE game_date BETWEEN ? AND ?");
        $stmt->execute([$startDate, $endDate]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($g) => new Game($g['id'], $g['game_date'], $g['description']), $data);
    }

    public static function findDetailsByGameId($id): GameData{
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM game_data WHERE game_id=?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $game = GameRepository::findById($id);
        $gameData = new GameData($game);
        $gameData -> setOtherAtributes($data['description'], $data['worms_quantity'], $data['worms_hp']);
        return $gameData;
    }

    public static function updateGameData($game_id,DataGameDto $gameData): ?GameData{
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE game_data SET description = ?, worms_quantity =? , worms_hp = ? where game_id=? ");
        $stmt->execute([$gameData -> description,$gameData ->worms_quantity, $gameData -> worms_hp , $game_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        print_r($data." ".$game_id);
        
        $game = GameRepository::findById($game_id);

        $gameData = new GameData($game);

        $gameData ->setOtherAtributes($gameData -> description, $gameData ->worms_quantity, $gameData -> worms_hp);

        return $gameData;
    }

}


?>