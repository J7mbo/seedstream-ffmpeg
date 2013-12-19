<?php

use FFmpeg\CommandResponse\Validator\CliValidator;

class CliValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FFmpeg\CommandResponse\Validator\CliValidator
     */
    private $validator;
    
    public function setUp()
    {
        $this->validator = new CliValidator();
    }
    
    /**
     * @unitTest
     */
    public function testInterface()
    {
        $this->assertTrue($this->validator instanceof CliValidator);
    }
    
    /**
     * @unitTest
     */
    public function testPermissionExceptionThrown()
    {
        $response = "this message has PERMISSION DENIED in it";
        $this->setExpectedException('FFmpeg\Exception\PermissionException');
        $this->validator->validate($response);
    }
    
    /**
     * @unitTest
     */
    public function testInvalidResponseExceptionThrown()
    {
        $response = array("ffmpeg is returning an invalid response here");
        $this->setExpectedException('FFmpeg\Exception\FFmpegInvalidResponseException');
        $this->validator->validate($response);
    }
    
    /**
     * @unitTest
     */
    public function testValidResponse()
    {
        $response = array("Some data here", "press ctrl-c to stop encoding", "another line");
        $this->assertTrue($this->validator->validate($response));
    }
}