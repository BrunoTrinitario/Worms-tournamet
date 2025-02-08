<?php
class NewPersonGameDto{
    public $person_id;
    public $game_id;
    public $game_points;
    public $mvp_points;
    public $damage_points;
    public $quantity_points;

    public function __construct($person_id,$game_id,$game_points,$mvp_points,$damage_points,$quantity_points)
    {
        $this->person_id = $person_id;
        $this->game_id = $game_id;
        $this->game_points = $game_points;
        $this->mvp_points = $mvp_points;
        $this->damage_points = $damage_points;
        $this->quantity_points = $quantity_points;
    }
}
?>