<?php
require_once __DIR__."/../repositories/PersonRepository.php";
require_once __DIR__."/../models/Game.php";
require_once __DIR__."/../util/PersonException.php";
require_once __DIR__."/../util/Constants.php";
class PersonService{
    public static function savePerson(Person $person): Person{
        if (PersonService::findByNick($person ->nick) == null){
            return PersonRepository::savePerson($person);
        }
        else{
            throw new PersonException(Constants::EXIST_PERSON);
        }
            
    }

    public static function findById($id): ?Person {
        try {
            $person = PersonRepository::findById($id);
            return $person;
        } catch (PDOException $e) {
            throw new PersonException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function findByNick($nick): ?Person {
        try {
            return PersonRepository::findByNick($nick);
        } catch (PDOException $e) {
            throw new Exception(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function getAllPersons(): array{
        try {
            return PersonRepository::findAll();
        } catch (PDOException $e) {
            throw new Exception(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function deleteById($id): void{
        try {
            PersonRepository::deleteById($id);
        } catch (PDOException $e) {
            throw new PersonException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

    public static function updatePersonById($id, $nick): Person{
        try {
            $person = PersonService::findById($id);
            if ($person == null){
                throw new PersonException(Constants::NOT_EXIST_PERSON);
            }else{
                $person -> nick = $nick;
                return PersonService::savePerson($person);
            }
        } catch (PDOException $e) {
            throw new PersonException(Constants::DB_ERROR."  ERROR: ". $e->getMessage());
        }
    }

}
?>