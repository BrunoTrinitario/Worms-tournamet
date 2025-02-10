<?php
require_once __DIR__."/../models/Game.php";
require_once __DIR__."/../config/db_utilities.php";
class GameRepository {
    public static function save(Game $game): Game {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO game (game_date,description) VALUES (?,?)");
        $stmt->execute([$game->date, $game->description]);
        $game->id = $pdo->lastInsertId();
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
}


?>