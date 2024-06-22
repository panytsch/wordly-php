<?php

namespace App\Providers;

use App\Subscribers\LanguageSelectedSubscriber;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventsProvider extends ServiceProvider
{
    public function boot()
    {
        Event::subscribe(LanguageSelectedSubscriber::class);
    }
}
