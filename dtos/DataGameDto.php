<?php
class DataGameDto{
    public $worms_quantity;
    public $worms_hp;
    public $description;

    public function __construct($worms_quantity, $worms_hp, $description){
        $this -> worms_quantity = $worms_quantity;
        $this ->worms_hp = $worms_hp;
        $this ->description = $description;
    }
}
?>