<?php

namespace App\Services;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Exception;

class Wallets
{
    public function generateNewAddress()
    {
        $nodePath = 'C:\Users\Hache\AppData\Roaming\nvm\v18.17.1\node.exe'; 
       
        // Ruta al archivo generateAddress.js
        $scriptPath = base_path('node_scripts/generateAddress.mjs');

        // Ejecutar el script Node.js
        $process = new Process([$nodePath, $scriptPath]);
        $process->run();

        // Manejar errores
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Obtener la salida del script
        $output = $process->getOutput();

        // Procesar la salida (por ejemplo, una dirección generada)
        $addressData = json_decode($output, true);

        return response()->json(['address' => $addressData]);
    }
}