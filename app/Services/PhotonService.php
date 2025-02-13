<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PhotonService
{
    private $appId;
    private $appSecret;
    private $region;

    public function __construct()
    {
        $this->appId = "726ec537-cf35-4d9d-a625-52d19dc9cab0"; //env('PHOTON_APP_ID');
        $this->region = "eu";//env('PHOTON_REGION', 'us'); // Región por defecto
    }

    public function createRoom($roomName, $maxPlayers, $customProperties = [])
    {
        $endpoint = "https://$this->region.api.photonengine.com/v1/app/$this->appId/createRoom";
        $response = Http::post($endpoint, [
            'RoomName' => $roomName,
            'MaxPlayers' => $maxPlayers,
            'CustomProperties' => $customProperties,
        ]);

        return $response->json();
    }
}
