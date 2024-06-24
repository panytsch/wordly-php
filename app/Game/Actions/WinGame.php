<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use function Laravel\Prompts\confirm;

class WinGame implements Action
{

    public function __construct(
        private AutoSavingState     $state,
        private TranslatorInterface $translator,
    )
    {
    }

    public function run(): void
    {
        IO::command()->info($this->translator->translate(TranslationKey::WIN));

        $this->state->finishGame(true);

        $wantToPlayAgain = confirm(
            label:    $this->translator->translate(TranslationKey::WANT_RETRY),
        );

        if ($wantToPlayAgain) {
            $this->runNewGame();
        }
    }

    private function runNewGame(): void
    {
        $this->state->refresh();

        /** @var StartGame $newGame */
        $newGame = resolve(StartGame::class);
        $newGame->run();
    }
}
