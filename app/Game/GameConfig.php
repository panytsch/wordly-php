<?php

namespace App\Game;

class GameConfig
{
    public function wordLength(): int
    {
        return 5;
    }

    public function triesToGuess(): int
    {
        return 5;
    }
}
