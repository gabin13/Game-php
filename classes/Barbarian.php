<?php

require_once('./classes/Ennemi.php');

class Barbarian extends Ennemi
{
    public function __construct()
    {
        $this->image = "barbarian";
        $this->hp = 10;
        $this->name = "Barbare";
        $this->power = 10;
        $this->constitution = 7;
        $this->speed = 8;
        $this->xp = 10;
        $this->gold = 20;
    }

    public function fear()
    {

    }
}