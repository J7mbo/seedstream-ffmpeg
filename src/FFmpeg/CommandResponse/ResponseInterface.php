<?php

namespace FFmpeg\CommandResponse;

use FFmpeg\CommandResponse\Validator\ValidatorInterface;

interface ResponseInterface
{
    /**
     * Class constructor
     * 
     * @param FFmpeg\CommandResponse\Validator\ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator);
    
    /**
     * Check if the response class member is a valid response.  This is a proxy 
     * call to validate() method of the ValidatorInterface class member
     * 
     * @note Validate() call can throw exception that bubbles past this method
     * 
     * @return bool The response from the validator->validate() call
     */
    public function isValid();
}