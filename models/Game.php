<?php
class Game {
    public $id;
    public $date;
    public $description;

    public function __construct($id, $date, $description) {
        $this->id = $id;
        $this->date = $date;
        $this->description = $description;
    }

}

?>