<?php

namespace App\Providers;

use App\Game\State\AutoSavingState;
use App\Game\State\CacheStorage;
use App\Game\State\GameSaveStorage;
use App\Game\State\State;
use App\Game\Translations\Translator;
use App\Game\Translations\TranslatorInterface;
use App\Game\WordProviders\WordProvider;
use App\Game\WordProviders\WordProviderInterface;
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
        $this->app->bind(GameSaveStorage::class, CacheStorage::class);
        $this->app->singleton(WordProviderInterface::class, WordProvider::class);
        $this->app->singleton(State::class);
        $this->app->singleton(AutoSavingState::class);
    }
}
