<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Suggestion;
use App\Models\Review;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share notification counts with admin layout
        View::composer('layouts.admin', function ($view) {
            $view->with([
                'pending_suggestions' => Suggestion::where('status', 'pending')->count(),
                'pending_reviews' => Review::where('status', 'pending')->count(),
                'pending_messages' => Message::where('status', 'pending')->count(),
            ]);
        });
    }
}
