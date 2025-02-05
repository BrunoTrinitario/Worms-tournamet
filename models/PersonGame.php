<?php
class PersonGame {
    public $id;
    public $person;
    public $game;
    public $game_points;
    public $mvp_points;
    public $damage_points;
    public $quantity_points;

    public function __construct($id, Person $person, Game $game, $game_points, $mvp_points, $damage_points, $quantity_points) {
        $this->id = $id;
        $this->person = $person;
        $this->game = $game;
        $this->game_points = $game_points;
        $this->mvp_points = $mvp_points;
        $this->damage_points = $damage_points;
        $this->quantity_points = $quantity_points;
    }
}