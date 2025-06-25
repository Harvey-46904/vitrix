<?php
namespace App\Helpers;

require_once __DIR__ . '/GifBuilder.php';

class GifEncoder
{
    private $frames = [];
    private $delays = [];
    private $loop = 0;

    public function addFrame(string $filePath, int $delayCs = 10)
    {
        $this->frames[] = file_get_contents($filePath);
        $this->delays[] = $delayCs;
    }

    public function save(string $outputPath)
    {
        $builder = new \GifBuilder();
        $gif = $builder->build($this->frames, $this->delays, $this->loop);
        file_put_contents($outputPath, $gif);
    }
}
