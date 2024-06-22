<?php

namespace App\Game\Translations\EN;

use App\Game\Translations\TranslationKey;
use App\Game\Translations\Translator as TranslatorInterface;

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
            default                       => null,
        };
    }
}
