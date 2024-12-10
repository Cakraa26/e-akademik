<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.header', function ($view) {
            $residenId = auth()->user()->pk; 
            $notifikasi = Notification::where('residenfk', $residenId)
                ->orderBy('dateadded', 'desc')
                ->limit(6)
                ->get();
    
            $view->with('notifikasi', $notifikasi);
        });
    }
}
