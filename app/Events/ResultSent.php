<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ResultSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $result = array();

    /**
     * ResultSent constructor.
     *
     * @param array  $result
     * @param String $market
     * @param String $currencyFrom
     */

    public function __construct(array $result, String $market, String $currencyFrom)
    {
        $this->result['currency_from'] = $currencyFrom;
        $this->result['market'] = $market;
        $this->result['values'] = $result;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('resultChannel');
    }
}
