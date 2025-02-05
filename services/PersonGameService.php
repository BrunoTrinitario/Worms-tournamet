<?php
require_once "../repositories/PersonGameRepository.php";
require_once "../models/PersonGame.php";
class PersonGameService {
    public static function create(PersonGame $personGame) {
        try {
            return PersonGameRepository::createPersonGame($personGame);
        } catch (Exception $e) {
            throw new Exception("Error en PersonGameService::create - " . $e->getMessage());
        }
    }
    public static function update(PersonGame $personGame) {
        try {
            return PersonGameRepository::updatePersonGame($personGame);
        } catch (Exception $e) {
            throw new Exception("Error en PersonGameService::update - " . $e->getMessage());
        }
    }
    public static function deleteById($id) {
        try {
            return PersonGameRepository::deleteById($id);
        } catch (Exception $e) {
            throw new Exception("Error en PersonGameService::deleteById - " . $e->getMessage());
        }
    }
}
?>