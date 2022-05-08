<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        \App\Models\Word::class => 'App\Http\Admin\Word',
        \App\Models\Anecdote::class => 'App\Http\Admin\Anecdote',
        \App\Models\Post::class => 'App\Http\Admin\Post',
        \App\Models\Calendar::class => 'App\Http\Admin\Calendar',
        \App\Models\Typecalendar::class => 'App\Http\Admin\Typecalendar',
//        \App\Models\User::class => 'App\Http\Admin\User',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
        parent::boot($admin);
    }
}
