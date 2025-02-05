<?php
    require_once "../config/db_utilities.php";
    require_once "../repositories/PersonRepository.php";
class PersonService{
    public static function savePerson(Person $person){

        return PersonRepository::savePerson($person);
    }

    public static function findById($id) {
        try {
            return PersonRepository::findById($id);
        } catch (Exception $e) {
            throw new Exception("Error en PersonService::findById - " . $e->getMessage());
        }
    }

    public static function findByNick($nick) {
        try {
            return PersonRepository::findByNick($nick);
        } catch (Exception $e) {
            throw new Exception("Error en PersonService::findByNick - " . $e->getMessage());
        }
    }

    public static function deleteById($id) {
        try {
            PersonRepository::deleteById($id);
        } catch (Exception $e) {
            throw new Exception("Error en PersonService::deleteById - " . $e->getMessage());
        }
    }

    public static function updatePersonById($id, $nick){
        try {
            $person = PersonService::findById($id);
            $person -> nick = $nick;
            PersonService::savePerson($person);
        } catch (Exception $e) {
            throw new Exception("Error en PersonService::deleteById - " . $e->getMessage());
        }
    }

}
?>