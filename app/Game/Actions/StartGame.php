<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\GameConfig;
use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use App\Game\WordProviders\WordProviderInterface;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\spin;

class StartGame implements Action
{
    public function __construct(
        private TranslatorInterface   $translator,
        private WordProviderInterface $wordProvider,
        private AutoSavingState       $state,
        private GameConfig            $gameConfig,
        private GuessWordAction       $nextGameAction,
    )
    {
    }

    public function run(): void
    {
        IO::clearConsole();

        $this->initWord();

        pause($this->translator->translate(TranslationKey::STARTING_GAME));

        $this->state->startGame();

        $this->runNextAction();
    }

    private function runNextAction(): void
    {
        $this->nextGameAction->run();
    }

    private function initWord(): void
    {
        $word = spin(
            fn () => $this->wordProvider->word($this->gameConfig->wordLength()),
            $this->translator->translate(TranslationKey::FETCHING_WORD),
        );

        $this->state->setWord($word);
    }
}
