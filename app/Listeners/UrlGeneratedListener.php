<?php

namespace App\Listeners;

use App\Events\UrlGenerated;
use App\Models\ShortUrl;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UrlGeneratedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(UrlGenerated $event)
    {
        ShortUrl::updateOrCreate([
            'key' => $event->getKey(),
        ], [
            'long_url' => $event->getLongUrl(),
            'expire_time' => $event->getExpireTimestamp(),
        ]);
    }
}
