<?php

namespace App\Game\Actions;

use App\Console\IO;
use App\Game\GameConfig;
use App\Game\State\AutoSavingState;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;

readonly class GuessWordAction implements Action
{
    public function __construct(
        private AutoSavingState     $state,
        private GameConfig          $gameConfig,
        private TranslatorInterface $translator,
        private WinGame             $winGameAction,
        private LoseGame            $loseGameAction,
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
        if ($this->state->numberOfGuesses() > 0) {
            $message = $this->translator->translate(TranslationKey::PREV_GUESSES);
            IO::command()->line($message);
            $this->formatPreviousResults();
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
        return $word === $this->state->getWord();
    }

    private function runWinGameAction(): void
    {
        $this->winGameAction->run();
    }

    private function runLoseGameAction(): void
    {
        $this->loseGameAction->run();
    }

    protected function formatPreviousResults(): void
    {
        $formatted = $this->state->previousGuesses()->map(
            fn (string $word) => $this->formatWord($word)
        );

        IO::command()->table([], $formatted);
    }

    private function formatWord(string $word): array
    {
        $letters = str_split($word);

        $result = [];
        foreach ($letters as $index => $letter) {
            $hiddenWord = $this->state->getWord();
            if ($hiddenWord[$index] === $letter) {
                $result [] = "<fg=black;bg=green> $letter </>";
            } elseif (Str::contains($hiddenWord, $letter)) {
                $result [] = "<fg=black;bg=white> $letter </>";
            } else {
                $result [] = " $letter ";
            }
        }

        return $result;
    }
}
