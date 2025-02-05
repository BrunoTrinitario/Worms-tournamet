<?php
class DataBaseException extends Exception{
    public $message;
    public  function __construct($message){
        $this -> $message = $message;
    }
}

?>