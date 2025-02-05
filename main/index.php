<?php
    require_once "../models/Person.php";
    require_once "../services/PersonService.php";
    require_once "../models/Game.php";
    require_once "../services/GameService.php";
    require_once "../services/PersonGameService.php";
    require_once "../models/PersonGame.php";
    $p1 = new Person(null,"art3");
    $p1 = PersonService :: savePerson($p1);
    $g1 = new Game(null, date("Y-m-d"));
    $g1 = GameService :: saveGame($g1);
    $pg1 = new PersonGame(null, $p1,$g1,1,1,1,1);
    PersonGameService::create($pg1)
?>