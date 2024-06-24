<?php

namespace App\Game\State;

use App\Game\Translations\SupportedLanguage;
use Illuminate\Support\Collection;

class GameStateSerializer
{

    public function __construct(private State $state)
    {
    }

    public function serialize(): array
    {
        return [
            'word'             => $this->state->word,
            'numberOfGuesses'  => $this->state->numberOfGuesses,
            'selectedLanguage' => $this->state->selectedLanguage->value,
            'previousGuesses'  => $this->state->previousGuesses->all(),
            'gameResult'       => $this->state->gameResult,
            'gameStarted'      => $this->state->gameStarted,
        ];
    }

    public function deserialize(array $data): State
    {
        $this->state->word = $data['word'];
        $this->state->numberOfGuesses = $data['numberOfGuesses'];
        $this->state->selectedLanguage = SupportedLanguage::from($data['selectedLanguage']);
        $this->state->previousGuesses = Collection::make($data['previousGuesses']);
        $this->state->gameResult = $data['gameResult'];
        $this->state->gameStarted = $data['gameStarted'];

        return $this->state;
    }
}
