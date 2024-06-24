<?php

namespace App\Game\State;

use App\Game\Translations\SupportedLanguage;
use Illuminate\Support\Collection;

class State
{
    public ?string $word;

    public int $numberOfGuesses = 0;

    public SupportedLanguage $selectedLanguage = SupportedLanguage::EN;

    /** @var Collection<string> */
    public Collection $previousGuesses;

    /**
     * @var bool|null
     *
     *  null - game in progress
     *  true - won
     *  false - lose
     */
    public ?bool $gameResult = null;

    public bool $gameStarted = false;

    public function __construct()
    {
        $this->previousGuesses = Collection::empty();
    }

    public function refresh(): void
    {
        $this->previousGuesses = Collection::empty();
        $this->gameStarted = false;
        $this->gameResult = null;
        $this->numberOfGuesses = 0;
        $this->word = null;
    }
}
