<?php
class PersonPointDto{
    public $person_id;
    public $person_nick;
    public $total_games_point;
    public $total_mvp_points;
    public $total_damage_points;
    public $total_quantity_points;
    public $total_games;

    public function __construct($person_id, $person_nick, $total_games_point, $total_mvp_points, $total_damage_points, $total_quantity_points, $total_games){
        $this -> person_id = $person_id;
        $this -> person_nick = $person_nick;
        $this -> total_games_point= $total_games_point;
        $this -> total_mvp_points = $total_mvp_points;
        $this -> total_damage_points = $total_damage_points;
        $this -> total_quantity_points = $total_quantity_points;
        $this -> total_games = $total_games;
    }

    public function __toString(){
        return "Person ID: ". $this ->person_id.
                " Person nick: ".$this ->person_nick.
                " total_games_point: ".$this ->total_games_point.
                " total_mvp_points: ".$this ->total_mvp_points.
                " total_damage_points: ".$this ->total_damage_points.
                " total_quantity_points: ".$this ->total_quantity_points.
                " total_games: ".$this ->total_games;
    }

}
?>