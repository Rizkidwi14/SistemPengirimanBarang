<?php

namespace App\Providers;

use app\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

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
        //menggunakan frontend bootstrap
        Paginator::useBootstrap();

        //ganti timezone ke Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Gate::define('admin', function (User $user) {
            return $user->role_id == 1;
        });

        Gate::define('toko', function (User $user) {
            return $user->role_id == 2;
        });

        Gate::define('driver', function (User $user) {
            return $user->role_id == 3;
        });

        Gate::define('manajer', function (User $user) {
            return $user->role_id == 4;
        });
    }
}
