<?php

namespace App\Listeners;

use App\Events\UrlGenerated;
use App\Events\UrlRequested;
use App\Models\ReqLog;
use App\Models\ShortUrl;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UrlRequestedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(UrlRequested $event)
    {
        $log = new ReqLog([
            'key' => $event->getKey(),
            'request_time' => $event->getRequestTimestamp(),
            'ip' => $event->getIp(),
        ]);
        $log->save();
    }
}
