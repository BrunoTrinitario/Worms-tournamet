<?php
require_once __DIR__."/../repositories/PersonGameRepository.php";
require_once __DIR__."/../models/PersonGame.php";
require_once __DIR__."/PersonService.php";
require_once __DIR__."/GameService.php";
require_once __DIR__."/../dtos/PersonPointDto.php";
require_once __DIR__."/../dtos/NewPersonGameDto.php";
class PersonGameService {
    public static function createPersonGame(NewPersonGameDto $personGame): PersonGame {
        try {
            $person = PersonService::findById($personGame ->person_id);
            $game = GameService::getGameById($personGame ->game_id);
            $personGame = new PersonGame(null, $person, $game, $personGame->game_points, $personGame->mvp_points, $personGame->damage_points, $personGame->quantity_points);
            return PersonGameRepository::createPersonGame($personGame);
        } catch (PDOException $e) {
            throw new PersonGameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        } catch (PersonException $e){
            throw new PersonGameException($e->getMessage());
        } catch (GameException $e){
            throw new PersonGameException($e->getMessage());
        }
    }
    
    public static function deleteById($id): void {
        try {
            PersonGameRepository::deleteById($id);
        } catch (PDOException $e) {
            throw new PersonGameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getAllInfomationGameForUsers():array{
        try {
            return PersonGameRepository::getAllInfomationGameForUsers();
        } catch (PDOException $e) {
            throw new PersonGameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getAllInfomationGameForOneUser($id): ?PersonPointDto{
        try {
            return PersonGameRepository::getAllInfomationGameForOneUser($id);
        } catch (PDOException $e) {
            throw new PersonGameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getAllGames():array{
        try {
            return PersonGameRepository::getAllGames();
        } catch (PDOException $e) {
            throw new PersonGameException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

}
?>