<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class BalanceControl implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $balance;
    public $userId;

    public function __construct($userId, $balance)
    {
        $this->balance = $balance;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('balances.' . $this->userId); // Canal privado
    }

    public function broadcastWith()
    {
        return [
            'balance' => $this->balance,
        ];
    }

    public function broadcastAs()
    {
        return 'BalanceUpdated';
    }
}
