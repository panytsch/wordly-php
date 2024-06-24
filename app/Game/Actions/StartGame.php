<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\GameConfig;
use App\Game\State\AutoSavingState;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use App\Game\WordProviders\RandomWordApiProvider;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\spin;

class StartGame implements Action
{
    public function __construct(
        private TranslatorInterface   $translator,
        private RandomWordApiProvider $wordApiProvider,
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

    private function initWord()
    {
        $word = spin(
            fn () => $this->word($this->gameConfig->wordLength()),
            $this->translator->translate(TranslationKey::FETCHING_WORD),
        );

        $this->state->setWord($word);
    }

    private function word(int $length): string
    {
        return match ($this->state->getLang()) {
            SupportedLanguage::EN => $this->wordApiProvider->englishWord($length),
            SupportedLanguage::ES => $this->wordApiProvider->spanishWord($length),
        };
    }
}
