<?php
require_once __DIR__ . "/../config/JWTutils.php";
class SecurityFilters{
    public static function JWTfilter($header){
        $token = str_replace('Bearer ', '', $header);
        $valid = JWTutils::validateToken($token);
        if ($valid){
            return true;
        }else{ 
            return false;  
        }
    }
}

?>