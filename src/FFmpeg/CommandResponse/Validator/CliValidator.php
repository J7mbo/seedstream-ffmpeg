<?php

namespace FFmpeg\CommandResponse\Validator;

use FFmpeg\Exception\FFmpegInvalidResponseException,
    FFmpeg\Exception\PermissionException;

class CliValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($response)
    {
        $response = is_array($response) ? implode(', ', $response) : $response;
        
        if (stristr($response, "permission denied"))
        {
            throw new PermissionException(sprintf("FFmpeg returned a permission exception during conversion, response: %s", $response));
        }
        elseif (stristr($response, "press ctrl-c to stop encoding"))
        {
            return true;
        }
        
        throw new FFmpegInvalidResponseException(sprintf("FFmpeg returned an invalid response during conversion, response: %s", $response));
    }    
}