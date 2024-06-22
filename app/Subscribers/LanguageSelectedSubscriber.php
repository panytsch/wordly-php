<?php

namespace App\Subscribers;

use App\Events\LanguageSelected;
use App\Game\Translations\SupportedLanguage;
use App\Game\Translations\TranslationFactory;
use App\Game\Translations\Translator as TranslatorInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Events\Dispatcher;

class LanguageSelectedSubscriber
{
    public function __construct(
        private TranslationFactory $translationFactory,
        private Container          $container,
    )
    {
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(LanguageSelected::class, $this->handle(...));
    }

    private function handle(LanguageSelected $event)
    {
        $this->saveTranslator($event->language);
    }

    private function saveTranslator(SupportedLanguage $language): void
    {
        $translator = $this->translationFactory->make($language);
        $this->container->instance(TranslatorInterface::class, $translator);
    }
}
