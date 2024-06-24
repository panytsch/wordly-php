<?php

namespace App\Subscribers;

use App\Events\LanguageSelected;
use App\Game\State\AutoSavingState;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\Translator;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Lang;

readonly class LanguageSelectedSubscriber
{
    public function __construct(
        private Translator      $translation,
        private AutoSavingState $state,
    )
    {
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(LanguageSelected::class, $this->handle(...));
    }

    private function handle(LanguageSelected $event): void
    {
        $this->saveTranslator($event->language);
        $this->saveToState($event->language);
    }

    private function saveTranslator(SupportedLanguage $language): void
    {
        $this->translation->replaceTranslator($language);
        Lang::setLocale($language->laravelLocale());
    }

    private function saveToState(SupportedLanguage $language): void
    {
        $this->state->setLang($language);
    }
}
