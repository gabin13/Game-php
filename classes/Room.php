<?php

class Room {
    private string $name;
    private string $description;
    private string $type;
    private int $donjon_id;
    private int $or;

    public function __construct($room)
    {
        $this -> name = $room['name'];
        $this -> description = $room['description'];
        $this -> type = $room['type'];
        $this -> donjon_id = $room['donjon_id'];
    }

    public function getName():string
    {
        return $this->name;
    }

    public function setName(string $name) :void 
    {
        $this->name = $name;
    }

    public function getDescription():string
    {
        return $this->description;
    }

    public function setDescription(string $description) :void 
    {
        $this->name = $description;
    }

    public function getHTML(): string
    {
        $html = "";

        switch ($this -> type) {
            case 'vide':
                $html .= "<a href='donjon_play.php?id=". $this->donjon_id ."'>Continuer l'exploration</a>";
                break;

            case 'treasur':
                $html .= "<p>Vous avez gagné ". $this->or ." pièces d'or</p>";
                $html .= "<a href='donjon_play.php?id=". $this->donjon_id ."'>Continuer l'exploration</a>";
                break;

            case 'combat':
                $html .= "<p class='new'><a href='donjon_fight.php?id=". $this->donjon_id ."'>Combattre</a></p>";
                $html .= "<p class='new'><a href='donjon_play.php?id=". $this->donjon_id ."'>Fuir et continuer l'exploration</a></p>";
                break;

            case 'boss':
                $html .= "<p class='new'><a href='donjon_fight.php?id=". $this->donjon_id ."'>Combattre</a></p>";
                break;

            default:
                $html .= "Aucune action possible !";
                break;
        }

        return $html;
    }

    public function makeAction(): void
    {
        switch ($this -> type) {
            case 'vide':
                break;

            case 'treasur':
                $this->or = rand(0, 20);
                $_SESSION['perso']['gold'] += $this->or;
                break;

            case 'combat':
                break;

            default:
                break;
        }
    }

}