<?php
require_once __DIR__."/Game.php";
class GameData{
    public Game $game;
    public $description;
    public $worms_quantity;
    public $worms_hp;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    public function setOtherAtributes($description, $worms_quantity, $worms_hp){
        $this->description = $description;
        $this->worms_quantity = $worms_quantity;
        $this->worms_hp = $worms_hp;
    }

    public function setGame(Game $game): void {
        $this->game = $game;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }


    public function setWormsQuantity(int $worms_quantity): void {
        if ($worms_quantity < 0) {
            throw new InvalidArgumentException("Worms quantity cannot be negative.");
        }
        $this->worms_quantity = $worms_quantity;
    }

    public function setWormsHp(int $worms_hp): void {
        if ($worms_hp < 0) {
            throw new InvalidArgumentException("Worms HP cannot be negative.");
        }
        $this->worms_hp = $worms_hp;
    }

}
?>