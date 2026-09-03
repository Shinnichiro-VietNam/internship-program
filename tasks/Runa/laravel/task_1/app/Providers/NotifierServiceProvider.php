<?php

namespace App\Providers;

use App\Contracts\Notifier;
use App\Notifiers\LogNotifier;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Notifier::class, LogNotifier::class);
    }

    public function boot(): void
    {
        //
    }
}
