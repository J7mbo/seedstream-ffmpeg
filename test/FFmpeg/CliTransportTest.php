<?php

use FFmpeg\CommandTransport\TransportInterface,
    FFmpeg\CommandTransport\CliTransport;

class CliTransportTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var FFmpeg\CommandTransport\CliTransport
     */
    private $transport;
    
    public function setUp()
    {
        $this->transport = new CliTransport();
    }
    
    /**
     * @unitTest
     */
    public function testInterface()
    {
        $this->assertTrue($this->transport instanceof TransportInterface);
    }
    
    /**
     * @integrationTest
     */
    public function testFFmpegCallable()
    {
        $result = $this->transport->convert('fakefile', 'fakefile');
        $this->assertTrue(stristr($result, "ffmpeg version") !== false);
    }
    
    /**
     * @integrationTest
     */
    public function testFFmpegNotInstalledExceptionThrown()
    {
        $this->setExpectedException("FFmpeg\Exception\FFmpegNotInstalledException");
        $this->transport->getExecPath("invalidFFmpegCommand");
    }
    
    /**
     * @integrationTest
     */
    public function testFFmpegBinaryNotFoundExceptionThrown()
    {
        $this->setExpectedException("FFmpeg\Exception\InvalidFFmpegBinaryException");
        $this->transport->setExecPath("invalidFFmpegBinary");
    }
}