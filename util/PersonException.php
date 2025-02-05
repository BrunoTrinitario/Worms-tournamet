<?php
class PersonException extends Exception{
    public $message;
    public  function __construct($message){
        $this -> $message = $message;
    }

    
}

?>