<?php

namespace FFmpeg\CommandDispatcher;

use FFmpeg\Exception\FFmpegInvalidResponseException,
    FFmpeg\CommandTransport\TransportInterface,
    FFmpeg\CommandResponse\ResponseInterface,
    FFmpeg\Exception\ConversionException,
    \Exception;

abstract class CommandDispatcher
{
    /**
     * @var FFmpeg\CommandTransport\TransportInterface
     */
    protected $transport;
    
    /**
     * @var FFmpeg\CommandResponse\ResponseInterface
     */
    protected $response;
    
    /**
     * Class constructor
     * 
     * @param FFmpeg\CommandTransport\TransportInterface $transport Usually cli
     * @param FFmpeg\CommandResponse\ResponseInterface   $response  Empty obj
     */
    public function __construct(TransportInterface $transport, ResponseInterface $response)
    {
        $this->transport = $transport;
        $this->response = $response;
    }

    /**
     * Perform a video conversion
     * 
     * @param string $from Filepath for the file to convert
     * @param string $to   Filepath to convert the file to
     * 
     * @note The exception is basically a more generalised re-throw
     * 
     * @throws FFmpeg\Exception\ConversionException When a conversion fails
     * 
     * @return bool True on successful conversion call 
     */
    public function convert($from, $to)
    {
        $response = $this->transport->convert($from, $to);
        
        $this->response->setResponse($response);
        
        try
        {
            return $this->response->isValid();
        }
        catch (Exception $e)
        {
            throw new ConversionException(sprintf("An error occured during a conversion attempt: %s", $e->getMessage()));
        }
    }
}