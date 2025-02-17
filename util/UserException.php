<?php
class UserException extends Exception{
    public $message;
    public function __construct($message){
        parent::__construct($message);
        $this -> message = $message;
    }
}
?>