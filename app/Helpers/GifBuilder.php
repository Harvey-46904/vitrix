<?php

class GifBuilder
{
    public function build(array $frames, array $durations, int $loop = 0)
    {
        $gif = "GIF89a";
        $gif .= chr(0) . chr(0) . chr(0);
        $gif .= chr(0) . chr(0) . chr(0);

        // Loop control extension
        $gif .= chr(0x21) . chr(0xFF) . chr(0x0B) . "NETSCAPE2.0" .
                chr(0x03) . chr(0x01) .
                chr($loop % 256) . chr(intval($loop / 256)) . chr(0);

        foreach ($frames as $index => $frame) {
            $gif .= chr(0x21) . chr(0xF9) . chr(0x04) . chr(0x08); // no transparency
            $gif .= chr($durations[$index]) . chr(0x00) . chr(0x00); // delay
            $gif .= $frame;
        }

        $gif .= chr(0x3B); // end of gif
        return $gif;
    }
}
