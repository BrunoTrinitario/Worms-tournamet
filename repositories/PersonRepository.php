<?php
class PersonRepository{

    public static function savePerson(Person $person) {
        try{
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
        }catch(Exception $e){

        }
    }

    public static function findById($id) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM person WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Person($data['nick'], $data['id']);
        }else{
            throw new PersonException("Person not found");
        }
    }

    public static function findByNick($nick) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM person WHERE nick = ?");
        $stmt->execute([$nick]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Person($data['nick'], $data['id']);
        }else{
            throw new PersonException("Person not found");
        }
    }

    public static function deleteById($id) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM person WHERE id = ?");
        return $stmt->execute([$id]);
    }

}
?>