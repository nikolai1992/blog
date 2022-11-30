<?php

namespace App\Providers;

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
        //
        view()->composer('layouts.app', function ($view) {
            $dashboard_url = "";
            if (auth()->user()) {
                if (auth()->user()->role->alias == "admin") {
                    $dashboard_url = route('admin.dashboard.blog');
                } elseif (auth()->user()->role->alias == "member") {
                    $dashboard_url = route('member.dashboard.blog');
                }
            }

            $view->with(['dashboard_url' => $dashboard_url]);
        });
    }
}
