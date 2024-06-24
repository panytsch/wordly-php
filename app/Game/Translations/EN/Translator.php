<?php

namespace App\Game\Translations\EN;

use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;

readonly class Translator implements TranslatorInterface
{

    public function translate(TranslationKey $key): string
    {
        $translated = $this->getTranslation($key);

        if ($translated === null) {
            throw new \InvalidArgumentException('translation does not exist');
        }

        return $translated;
    }

    private function getTranslation(TranslationKey $key): ?string
    {
        return match ($key) {
            TranslationKey::CHOSE_LANG    => 'Chose language',
            TranslationKey::STARTING_GAME => 'Starting game. Press Enter to continue',
            TranslationKey::FETCHING_WORD => 'Fetching word...',
            TranslationKey::SAVE_PROGRESS => 'Would you like to save your progress?',
            TranslationKey::LOAD_PROGRESS => 'Do you want to restore progress?',
            TranslationKey::PREV_GUESSES  => 'You previous guesses:',
            TranslationKey::GUESS_WORD    => 'Enter your word:',
            default                       => null,
        };
    }
}
