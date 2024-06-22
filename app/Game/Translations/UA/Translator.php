<?php

namespace App\Game\Translations\UA;

use App\Game\Translations\TranslationKey;
use App\Game\Translations\Translator as TranslatorInterface;

class Translator implements TranslatorInterface
{

    public function __construct(private TranslatorInterface $fallbackTranslator)
    {
    }

    public function translate(TranslationKey $key): string
    {
        $translated = $this->getTranslation($key);

        if ($translated === null) {
            return $this->fallbackTranslator->translate($key);
        }

        return $translated;
    }

    private function getTranslation(TranslationKey $key): ?string
    {
        return match ($key) {
            TranslationKey::CHOSE_LANG    => 'Оберіть мову',
            TranslationKey::STARTING_GAME => 'Починаємо гру! Натисніть Enter щоб продовжити',
            default                       => null,
        };
    }
}
