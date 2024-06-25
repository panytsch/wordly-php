<?php

namespace App\Subscribers;

use App\Events\LanguageSelected;
use App\Game\State\AutoSavingState;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\Translator;
use App\Game\WordProviders\EnglishWordProvider;
use App\Game\WordProviders\SpanishWordProvider;
use App\Game\WordProviders\WordProviderInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Lang;

readonly class LanguageSelectedSubscriber
{
    public function __construct(
        private Translator            $translation,
        private AutoSavingState       $state,
        private WordProviderInterface $wordProvider,
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
        $this->saveWordProvider($event->language);
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

    private function saveWordProvider(SupportedLanguage $language): void
    {
        $provider = match ($language) {
            SupportedLanguage::EN => resolve(EnglishWordProvider::class),
            SupportedLanguage::ES => resolve(SpanishWordProvider::class),
        };

        $this->wordProvider->setProvider($provider);
    }
}
