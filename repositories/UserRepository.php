<?php
require_once __DIR__."/../config/db_utilities.php";
require_once __DIR__."/../models/User.php";
class UserRepository{
    public static function save(User $user): User{
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$user->username, $user->password]);	
        $user->id=$db->lastInsertId();
        return $user;
    }
    public static function findByUsername($username): ?User{
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data['id'], $data['username'], $data['password']);
        }else{  
            return null;
        }
    }
    public static function findById($id): ?User{
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetchObject("User");
        return $user;
    }
}
?>