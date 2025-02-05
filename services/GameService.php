<?php
require_once "../repositories/GameRepository.php";
require_once "../models/Game.php";
class GameService {

    public static function saveGame(Game $game) {
        try {
            return GameRepository:: save($game);
        } catch (Exception $e) {
            throw new Exception("Error en GameService::saveGame - " . $e->getMessage());
        }
    }

    public static function getGameById($id) {
        try {
            $game = GameRepository::findById($id);
            return $game;
        } catch (Exception $e) {
            throw new Exception("Error en GameService::getGameById - " . $e->getMessage());
        }
    }

    public static function getGamesByDate($date) {
        try {
            $games = GameRepository::findByDate($date);
            return $games;
        } catch (Exception $e) {
            throw new Exception("Error en GameService::getGamesByDate - " . $e->getMessage());
        }
    }
    public static function deleteGameById($id) {
        try {
            GameRepository::deleteById($id);
        } catch (Exception $e) {
            throw new Exception("Error en GameService::deleteGameById - " . $e->getMessage());
        }
    }

    public static function getGamesBetweenDates($startDate, $endDate) {
        try {
            $games = GameRepository::findBetweenDates($startDate, $endDate);
            return $games;
        } catch (Exception $e) {
            throw new Exception("Error en GameService::getGamesBetweenDates - " . $e->getMessage());
        }
    }
}
?>