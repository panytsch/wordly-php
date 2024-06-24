<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use Illuminate\Support\Str;
use function Laravel\Prompts\confirm;

class LoseGame implements Action
{

    public function __construct(
        private AutoSavingState     $state,
        private TranslatorInterface $translator,
    )
    {
    }

    public function run(): void
    {
        IO::command()->info($this->translator->translate(TranslationKey::LOSE));

        $this->state->finishGame(false);

        IO::command()->info(Str::replace(
            '%word%',
            $this->state->getWord(),
            $this->translator->translate(TranslationKey::ANSWER)
        ));

        $wantToPlayAgain = confirm(
            label: $this->translator->translate(TranslationKey::WANT_RETRY),
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
