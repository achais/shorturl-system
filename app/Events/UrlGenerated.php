<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UrlGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $key;

    protected $longUrl;

    protected $expireTimestamp;

    public function __construct($key, $longUrl, $expireTimestamp)
    {
        $this->key = $key;
        $this->longUrl = $longUrl;
        $this->expireTimestamp = $expireTimestamp;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getLongUrl()
    {
        return $this->longUrl;
    }

    public function getExpireTimestamp()
    {
        return $this->expireTimestamp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
