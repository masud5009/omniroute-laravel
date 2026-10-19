<?php

namespace App\Providers;

use App\Models\AiProvider;
use App\Models\GatewayKey;
use App\Models\GatewayLog;
use App\Models\ProviderAccount;
use App\Models\RoutingCombo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.dashboard', function ($view) {
            $view->with([
                'sidebarProvidersCount' => AiProvider::count(),
                'sidebarCombosCount' => RoutingCombo::count(),
                'sidebarKeysCount' => GatewayKey::count(),
                'sidebarLogsCount' => GatewayLog::count(),
                'modalProviders' => AiProvider::where('is_active', true)->get(),
            ]);
        });
    }
}
