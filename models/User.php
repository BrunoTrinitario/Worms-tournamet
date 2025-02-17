<?php
require_once __DIR__."/UserRole.php";
class User{
    public $id;
    public $username;
    public $password;
    public UserRole $role;
    public function __construct($id, $username, $password, $role){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }
    public function getRole(): string{
        return $this->role->value;
    }
}
?>