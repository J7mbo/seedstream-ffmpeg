<?php

namespace FFmpeg\CommandResponse\Validator;

interface ValidatorInterface
{
    /**
     * Validate a response from the ffmpeg convert call
     * 
     * @param mixed $response Response from a TransportInterface
     * 
     * @throws FFmpeg\Exception\PermissionException on write permissions issue
     * @throws FFmpeg\Exception\FFmpegInvalidResponseException on validate fail
     * 
     * @return true if the conversion worked, else above exception is thrown
     */
    public function validate($response);
}