<?php

namespace App\Providers;

use Carbon\Carbon;
use  App\Models\Calendar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        setlocale(LC_TIME, 'uk.UTF-8');
        Carbon::setLocale(config('app.locale'));
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        // для формы  своя  заявка
        $calendarForm=Calendar::orderBy('date')->get();
        \View::share('calendarForm', $calendarForm);
    }
}
