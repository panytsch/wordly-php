<?php

namespace App\Console\Commands;

use App\Game\Game;
use Illuminate\Console\Command;

class StartGameCommand extends Command
{
    protected $signature = 'game:start';

    protected $description = 'Start Game';

    /**
     * Execute the console command.
     */
    public function handle(Game $game)
    {
        $game->start();
    }
}
