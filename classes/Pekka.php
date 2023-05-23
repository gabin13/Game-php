<?php

require_once('./classes/Ennemi.php');

class Pekka extends Ennemi
{
    public function __construct()
    {
        $this->image = "pekka";
        $this->hp = 20;
        $this->name = "Pekka";
        $this->power = 12;
        $this->constitution = 20;
        $this->speed = 5;
        $this->xp = 100;
        $this->gold = 50;
    }

    public function fear()
    {

    }
}