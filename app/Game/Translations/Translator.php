<?php

namespace App\Game\Translations;

use App\Game\State\AutoSavingState;

class Translator implements TranslatorInterface
{
    private ?TranslatorInterface $translator = null;

    public function __construct(
        private TranslationFactory $translationFactory,
        private AutoSavingState    $state,
    )
    {
    }

    public function translate(TranslationKey $key): string
    {
        return $this->translator()->translate($key);
    }

    public function replaceTranslator(SupportedLanguage $language): void
    {
        $this->translator = $this->translationFactory->make($language);
    }

    private function translator(): TranslatorInterface
    {
        if ($this->translator === null) {
            $this->translator = $this->translationFactory->make($this->state->getLang());
        }

        return $this->translator;
    }
}
