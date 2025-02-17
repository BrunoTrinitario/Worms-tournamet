<?php
require_once __DIR__."/../repositories/UserRepository.php";
require_once __DIR__."/../config/JWTutils.php";
require_once __DIR__."/../dtos/TokenDto.php";
require_once __DIR__."/../util/UserException.php";

class AuthService{
    public static function register($username, $password){
        $user = UserRepository::findByUsername($username);
        if ($user != null){
            throw new Exception("User already exists");
        }
        $user = new User(null, $username, password_hash($password, PASSWORD_DEFAULT), UserRole::USER);
        UserRepository::save($user);
    }
    public static function login($username, $password): ?TokenDto{
        $user = UserRepository::findByUsername($username);
        if ($user == null){
            throw new UserException("User not found");
        }
        if (!password_verify($password, $user->password)){
            throw new UserException("Invalid password");
        }

        return new TokenDto(JWTutils::generateToken($user->id, $user->role));
    }
}

?>