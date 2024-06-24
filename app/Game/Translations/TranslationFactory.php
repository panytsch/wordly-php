<?php

namespace App\Game\Translations;

use App\Game\Translations\EN\Translator as ENTranslator;
use App\Game\Translations\ES\Translator as ESTranslator;
use Illuminate\Container\Container;

class TranslationFactory
{

    public function __construct(private Container $container)
    {
    }

    public function make(SupportedLanguage $language): TranslatorInterface
    {
        return match ($language) {
            SupportedLanguage::EN => new ENTranslator(),
            SupportedLanguage::ES => new ESTranslator(new ENTranslator()),
            default               => throw new \InvalidArgumentException('Unknown language'),
        };
    }
}
