<?php
namespace App\Helpers;

class GifCreator
{
    private $frames = [];
    private $durations = [];
    private $loop = 0;

    public function addFrame(string $path, int $durationCs = 10)
    {
        $this->frames[] = file_get_contents($path);
        $this->durations[] = $durationCs;
    }

    public function createGif()
    {
        if (empty($this->frames)) {
            throw new \Exception("No frames provided");
        }

        $gif = '';
        $gif .= "GIF89a";

        $gc = new \Imagick();
        foreach ($this->frames as $i => $frame) {
            $gc->readImageBlob($frame);
            $gc->setImageDelay($this->durations[$i]);
        }
        $gc->setImageIterations($this->loop);
        $gc->setImageFormat("gif");
        $gif = $gc->getImagesBlob();
        $gc->clear();
        $gc->destroy();

        return $gif;
    }

    public function save(string $path)
    {
        $gif = $this->createGif();
        file_put_contents($path, $gif);
    }

    public function setLoop(int $loop)
    {
        $this->loop = $loop;
    }
}