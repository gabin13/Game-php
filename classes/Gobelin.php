<?php

require_once('./classes/Ennemi.php');

class Gobelin extends Ennemi
{
    public function __construct()
    {
        $this->hp = 3;
        $this->image = "gobelin";
        $this->name = "Gobelin";
        $this->power = 10;
        $this->constitution = 8;
        $this->speed = 7;
        $this->xp = 4;
        $this->gold = 10;
    }

    public function runaway()
    {

    }
}