<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PanggilObatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($nama_pasien, $kd_loket_farmasi, $nomor_antrian)
    {
        $this->message = [
            'nama_pasien' => $nama_pasien,
            'kd_loket_farmasi' => $kd_loket_farmasi,
            'nomor_antrian' => $nomor_antrian,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('messages'.$this->message['kd_loket_farmasi']);
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
