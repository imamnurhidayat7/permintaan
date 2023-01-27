<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class Notification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $pesan;
    public $judul;
    public $url;
    public $date;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pesan, $judul, $url, $date, $id)
    {
        $this->pesan = $pesan;
        $this->judul = $judul;
        $this->url = $url;
        $this->date = $date;
        $this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['notification'.$this->id];
    }
}
