<?php
require_once __DIR__."/../models/Person.php";
require_once __DIR__."/../config/db_utilities.php";
class PersonRepository{
    public static function savePerson(Person $person): Person {
        $pdo = Database::connect();
        if ($person->id) {
            $stmt = $pdo->prepare("UPDATE person SET nick = ? WHERE id = ?");
            $stmt->execute([$person->nick, $person->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO person (nick) VALUES (?)");
            $stmt->execute([$person->nick]);
            $person -> id =  $pdo->lastInsertId();
        }
        return $person;
    }

    public static function findById($id): ?Person {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM person WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Person($data['id'], $data['nick']);
        }else{
            return null;
        }
    }

    public static function findAll(): array{
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM person");
        $stmt->execute([]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $persons=[];
        foreach ($data as $element){
            $persons[] = new Person($element['id'], $element['nick']);
        }
        return $persons;
    }

    public static function findByNick($nick): ?Person {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM person WHERE nick = ?");
        $stmt->execute([$nick]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Person($data['id'], $data['nick']);
        }else{
            return null;
        }
    }

    public static function deleteById($id): void {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM person WHERE id = ?");
        $stmt->execute([$id]);
    }

}
?>