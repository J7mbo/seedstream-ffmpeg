<?php

namespace FFmpeg\CommandResponse;

use FFmpeg\CommandResponse\Validator\ValidatorInterface;

abstract class CommandResponse implements ResponseInterface
{
    /**
     * @var FFmpeg\CommandResponse\Validator\ValidatorInterface
     */
    protected $validator;
    
    /**
     * @var string
     */
    protected $response;
    
    /**
     * Set the response retrieved
     * 
     * @param mixed $response
     * 
     * @return CommandResponse
     */
    public function setResponse($response)
    {
        $this->response = $response;
        
        return $this;
    }
    
    /**
     * Retrieve the response
     * 
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->validator->validate($this->getResponse());
    }
}