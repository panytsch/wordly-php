<?php

namespace App\Providers;

use App\Game\State\AutoSavingState;
use App\Game\State\State;
use App\Game\Translations\Translator;
use App\Game\Translations\TranslatorInterface;
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
        $this->app->bind(TranslatorInterface::class, Translator::class);
        $this->app->singleton(State::class);
        $this->app->singleton(AutoSavingState::class);
    }
}
