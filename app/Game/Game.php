<?php

namespace App\Game;

use App\Game\Actions\ChoseLanguage;

readonly class Game
{
    public function __construct(private ChoseLanguage $startAction)
    {
    }

    public function start(): void
    {
        $this->startAction->run();
    }
}
