<?php

namespace App\Game\Actions;

use App\Events\LanguageSelected;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\TranslationKey;
use App\Game\Translations\TranslatorInterface;
use function Laravel\Prompts\select;

readonly class ChoseLanguage implements Action
{

    public function __construct(
        private TranslatorInterface $translator,
        private LoadSave            $startGame,
    )
    {
    }

    public function run(): void
    {
        $selectedLanguage = select(
            label:   $this->translator->translate(TranslationKey::CHOSE_LANG),
            options: [
                         SupportedLanguage::ES->value,
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
