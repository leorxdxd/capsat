<?php

namespace App\Providers;

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
        try {
            // Share system settings with all views
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::getAllGrouped();
                
                $systemName = $settings['general']['system_name'] ?? 'CAPSAT';
                $systemTitle = $settings['general']['system_title'] ?? 'Basic Education Department';
                $systemLogo = $settings['general']['system_logo'] ?? null;
                $primaryColor = $settings['general']['system_primary_color'] ?? '#2E1065';
                $accentColor = $settings['general']['system_accent_color'] ?? '#F59E0B';

                \Illuminate\Support\Facades\View::share('systemName', $systemName);
                \Illuminate\Support\Facades\View::share('systemTitle', $systemTitle);
                \Illuminate\Support\Facades\View::share('systemLogo', $systemLogo);
                \Illuminate\Support\Facades\View::share('primaryColor', $primaryColor);
                \Illuminate\Support\Facades\View::share('accentColor', $accentColor);
            }
        } catch (\Exception $e) {
            // Fallback if settings table query fails (e.g., during migration)
            \Illuminate\Support\Facades\View::share('systemName', 'CAPSAT');
            \Illuminate\Support\Facades\View::share('systemTitle', 'Basic Education Department');
            \Illuminate\Support\Facades\View::share('systemLogo', null);
            \Illuminate\Support\Facades\View::share('primaryColor', '#2E1065');
            \Illuminate\Support\Facades\View::share('accentColor', '#F59E0B');
        }
    }
}
