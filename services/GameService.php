<?php
require_once __DIR__."/../repositories/GameRepository.php";
require_once __DIR__."/../models/Game.php";
require_once __DIR__."/../util/GameException.php";
require_once __DIR__."/../util/Constants.php";
class GameService {

    public static function saveGame(Game $game): Game {
        try {
            return GameRepository::save($game);
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getGameById($id): ?Game {
        try {
            $game = GameRepository::findById($id);
            return $game;
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getGamesByDate($date): array {
        try {
            $games = GameRepository::findByDate($date);
            return $games;
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }
    
    public static function deleteGameById($id): void {
        try {
            GameRepository::deleteById($id);
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getAllGames():array{
        try {
            return GameRepository::findAll();
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getGamesBetweenDates($startDate, $endDate): array {
        try {
            $games = GameRepository::findBetweenDates($startDate, $endDate);
            return $games;
        } catch (PDOException $e) {
            throw new GameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }
}
?>