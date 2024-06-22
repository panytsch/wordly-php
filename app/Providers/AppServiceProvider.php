<?php

namespace App\Providers;

use App\CurrencyRate\Contracts\CurrencyRateInterface;
use App\CurrencyRate\CurrencyRate;
use App\Game\Translations\EN\Translator;
use App\Game\Translations\Translator as TranslatorInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->instance(TranslatorInterface::class, new Translator());
    }
}
