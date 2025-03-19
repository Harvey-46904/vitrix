<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Client\connect;

class ListenTronEvents extends Command
{
    protected $signature = 'tron:listen-events';
    protected $description = 'Escucha eventos de TronGrid en tiempo real';

    public function handle()
    {
        $url = "wss://nile.trongrid.io/ws"; // WebSocket de TronGrid en Nile Testnet

        connect($url)->then(function ($conn) {
            // Enviar el mensaje de suscripción
            $subscribeMessage = [
                "type" => "subscribe",
                "eventName" => "ReceivedUSDT",
                "contractAddress" => "TBq6tXJfPpbhQEBYnSh4aQyzycceFu15XJ"
            ];

            $conn->send(json_encode($subscribeMessage));

            // Escuchar respuestas
            $conn->on('message', function ($msg) use ($conn) {
                $data = json_decode($msg, true);
                
                if (!empty($data['result'])) {
                    foreach ($data['result'] as $event) {
                        \Log::info("Evento recibido: " . json_encode($event));
                    }
                }
            });

            $conn->on('close', function ($code = null, $reason = null) {
                \Log::error("WebSocket desconectado: Código $code, Motivo: $reason");
            });

        }, function ($e) {
            \Log::error("Error en WebSocket: " . $e->getMessage());
        });
    }
}
