<?php

namespace App\Listeners;

use App\Events\UrlDeleted;
use App\Models\ShortUrl;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UrlDeletedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(UrlDeleted $event)
    {
        ShortUrl::deleteByKey($event->getKey());
    }
}
