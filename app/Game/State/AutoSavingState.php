<?php

namespace App\Game\State;

use App\Game\Translations\TranslatorInterface;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\TranslationKey;
use Illuminate\Support\Collection;
use function Laravel\Prompts\confirm;

class AutoSavingState
{

    public function __construct(private State $state)
    {
    }

    public function isGameFinished(): bool
    {
        return $this->state->gameResult !== null;
    }

    public function finishGame(bool $result): self
    {
        $this->state->gameResult = $result;

        return $this;
    }

    public function setWord(string $word): self
    {
        $this->state->word = $word;

        return $this;
    }

    public function getWord(): string
    {
        return $this->state->word;
    }

    public function previousGuesses(): Collection
    {
        return $this->state->previousGuesses;
    }

    public function addGuess(string $word): self
    {
        $this->state->previousGuesses->push($word);

        return $this;
    }

    public function guessIncrement(): self
    {
        $this->state->numberOfGuesses++;

        return $this;
    }

    public function numberOfGuesses(): int
    {
        return $this->state->numberOfGuesses;
    }

    public function getLang(): SupportedLanguage
    {
        return $this->state->selectedLanguage;
    }

    public function setLang(SupportedLanguage $language): self
    {
        $this->state->selectedLanguage = $language;

        return $this;
    }

    public function startGame(): self
    {
        $this->state->gameStarted = true;

        return $this;
    }

    public function gameStarted(): bool
    {
        return $this->state->gameStarted;
    }

    public function __destruct()
    {
        if (!$this->gameStarted() || $this->isGameFinished()) {
            return;
        }

        /** @var \App\Game\Translations\TranslatorInterface $translator */
        $translator = resolve(TranslatorInterface::class);
        $shouldSave = confirm($translator->translate(TranslationKey::SAVE_PROGRESS));

        if ($shouldSave) {
            $this->saveProgress();
        }
    }

    public function refresh(): self
    {
        $this->state->refresh();

        return $this;
    }

    private function saveProgress()
    {
        // todo
    }
}
