<?php

namespace App\Providers;

use App\Events\UrlDeleted;
use App\Events\UrlGenerated;
use App\Events\UrlRequested;
use App\Listeners\UrlDeletedListener;
use App\Listeners\UrlGeneratedListener;
use App\Listeners\UrlRequestedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //短链生成事件
        UrlGenerated::class => [
            UrlGeneratedListener::class,
        ],
        //短链删除事件
        UrlDeleted::class => [
            UrlDeletedListener::class,
        ],
        //短链访问时间
        UrlRequested::class => [
            UrlRequestedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
