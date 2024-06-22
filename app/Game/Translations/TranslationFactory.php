<?php

namespace App\Game\Translations;

use App\Game\Translations\EN\Translator as ENTranslator;
use App\Game\Translations\UA\Translator as UATranslator;
use Illuminate\Container\Container;

class TranslationFactory
{

    public function __construct(private Container $container)
    {
    }

    public function make(SupportedLanguage $language)
    {
        return match ($language) {
            SupportedLanguage::EN => new ENTranslator(),
            SupportedLanguage::UA => new UATranslator(new UATranslator()),
            default               => throw new \InvalidArgumentException('Unknown language'),
        };
    }
}
