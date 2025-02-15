<?php
require_once __DIR__."/../repositories/UserRepository.php";
require_once __DIR__."/../config/JWTutils.php";
require_once __DIR__."/../dtos/TokenDto.php";
class AuthService{
    public static function register($username, $password){
        $user = UserRepository::findByUsername($username);
        if ($user != null){
            throw new Exception("User already exists");
        }
        $user = new User(null, $username, password_hash($password, PASSWORD_DEFAULT));
        UserRepository::save($user);
    }
    public static function login($username, $password): ?TokenDto{
        $user = UserRepository::findByUsername($username);
        if ($user == null){
            throw new Exception("User not found");
        }
        if (!password_verify($password, $user->password)){
            throw new Exception("Invalid password");
        }

        return new TokenDto(JWTutils::generateToken($user->id));
    }
}

?>