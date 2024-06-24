<?php

namespace App\Game\Actions;

use App\Game\GameConfig;
use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslatorInterface;
use App\Game\Translations\TranslationKey;
use function Laravel\Prompts\text;

readonly class GuessWordAction implements Action
{

    public function __construct(
        private AutoSavingState     $state,
        private GameConfig          $gameConfig,
        private TranslatorInterface $translator,
    )
    {
    }

    public function run(): void
    {
        while ($this->proceedWithGuesses()) {
            $this->showPreviousGuesses();
            $this->guessWord();

            if ($this->checkWord()) {
                $this->runWinGameAction();
                break;
            }
        }

        $this->runLoseGameAction();
        $this->state->finishGame(false);
    }

    protected function proceedWithGuesses(): bool
    {
        return $this->state->numberOfGuesses() < $this->gameConfig->triesToGuess();
    }

    private function showPreviousGuesses(): void
    {
        if (!$this->state->previousGuesses()) {
            return;
        }
        \Laravel\Prompts\info($this->translator->translate(TranslationKey::PREV_GUESSES));

        foreach ($this->state->previousGuesses() as $guess) {
            \Laravel\Prompts\info($guess);
        }
    }

    private function guessWord(): void
    {
        $wordLength = $this->gameConfig->wordLength();
        $word = text(
            label:    $this->translator->translate(TranslationKey::GUESS_WORD),
            required: true,
            validate: ['string', "min:$wordLength", "max:$wordLength"],
        );

        $this->state->addGuess($word)
                    ->guessIncrement();

    }

    private function checkWord(): bool
    {
        $word = $this->state->previousGuesses()->last();
        if ($word === $this->state->getWord()) {
            $this->state->finishGame(true);

            return true;
        }

        return false;
    }

    private function runWinGameAction()
    {
    }

    private function runLoseGameAction()
    {
    }
}
