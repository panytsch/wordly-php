<?php

namespace App\Game\Actions;

use App\Events\LanguageSelected;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\Translator;
use Illuminate\Contracts\Container\Container;
use function Laravel\Prompts\select;

class ChoseLanguage implements Action
{

    public function __construct(
        private Translator $defaultTranslator,
        private Container  $container,
        private StartGame  $startGame,
    )
    {
    }

    public function run(): void
    {
        $selectedLanguage = select(
            label:   $this->defaultTranslator->translate(TranslationKey::CHOSE_LANG),
            options: [
                         SupportedLanguage::UA->value,
                         SupportedLanguage::EN->value,
                     ],
            default: SupportedLanguage::EN->value
        );

        LanguageSelected::dispatch($selectedLanguage);

        $this->runNextAction();
    }

    private function runNextAction(): void
    {
        $this->startGame->run();
    }
}
