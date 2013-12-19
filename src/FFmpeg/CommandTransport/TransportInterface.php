<?php

namespace FFmpeg\CommandTransport;

interface TransportInterface
{
    /**
     * Send the conversion request to the transport method
     * 
     * @param string $from Filepath for the file to convert
     * @param string $to   Filepath to convert the file to
     * 
     * @return string The response from the transport call
     */
    public function convert($from, $to);
}