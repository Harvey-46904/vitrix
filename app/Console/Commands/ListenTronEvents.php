<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ListenTronEvents extends Command
{
    protected $signature = 'tron:listen-events';
    protected $description = 'Escucha eventos de TronGrid en tiempo real';

    public function handle()
    {
        \Ratchet\Client\connect('wss://echo.websocket.org:443')->then(function($conn) {
            $conn->on('message', function($msg) use ($conn) {
                echo "Received: {$msg}\n";
                $conn->close();
            });
        
            $conn->send('Hello World!');
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}
