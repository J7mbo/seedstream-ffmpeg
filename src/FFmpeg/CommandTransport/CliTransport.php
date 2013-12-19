<?php

namespace FFmpeg\CommandTransport;

use FFmpeg\Exception\InvalidFFmpegBinaryException,
    FFmpeg\Exception\FFmpegNotInstalledException;

class CliTransport implements TransportInterface
{
    /**
     * @var string
     */
    private $convertParams;
    
    /**
     * @var string
     */
    private $logFilePath;
    
    /**
     * @var string
     */
    private $execPath;

    /**
     * Set the conversoin params ffmpeg will use
     * 
     * @param string $convertParams
     * 
     * @return CliTransport
     */
    public function setConvertParams($convertParams)
    {
        $this->convertParams = $convertParams;
        
        return $this;
    }
    
    /**
     * Get convert params
     * 
     * @return string
     */
    public function getConvertParams()
    {
        return $this->convertParams;
    }
    
    /**
     * Set the executable path to be called via command line
     * 
     * @param string $execPath
     * 
     * @throws FFmpeg\Exception\InvalidFFmpegBinaryException when path set wrong
     * 
     * @return CliTransport
     */
    public function setExecPath($execPath)
    {
        exec(sprintf('nohup %s 2>&1 &', $execPath), $data);

        if (stristr(is_array($data) ? implode(', ', $data) : $data, "nohup: failed to run command"))
        {
            throw new InvalidFFmpegBinaryException(sprintf("Invalid execPath for FFmpeg: %s", $execPath));
        }
        
        $this->execPath = $execPath;
        
        return $this;
    }
    
    /**
     * Lazy instantiation
     *
     * @param string $default The command to auto-find ffmpeg with
     * 
     * @return string
     */
    public function getExecPath($default = "ffmpeg")
    {
        if (!$this->execPath)
        {
            $this->setExecPath($this->findFFmpeg($default));
        }
        
        return $this->execPath;
    }
    
    /**
     * Set the file path for logging output to be parsed for progression
     * 
     * @param string $logFilePath
     * 
     * @return CliTransport
     */
    public function setLogFilePath($logFilePath)
    {
        $this->logFilePath = $logFilePath;

        return $this;     
    }
    
    /**
     * Get the logging output path to be parsed for progression
     * 
     * @return string
     */
    public function getLogFilePath()
    {
        return $this->logFilePath;
    }
    
    /**
     * {@inheritdoc}
     */
    public function convert($from, $to)
    {
        exec(sprintf("nohup %s -i %s %s -y %s 2>&1 | tee %s &", $this->getExecPath(), $from, $this->getConvertParams(), $to, $this->getLogFilePath()), $data);
        return is_array($data) ? implode(' ', $data) : $data;
    }
    
    /**
     * Helper function to find ffmpeg binary
     * 
     * @param string $binary The binary to auto-search for
     * 
     * @throws FFmpeg\Exception\FFmpegNotInstalledException when not found
     * 
     * @return string Path to ffmpeg
     */
    private function findFFmpeg($binary)
    {
        exec(sprintf("whereis %s | awk {'print $2'}", $binary), $data);
        
        if (is_array($data) && !empty($data) && $data[0] !== '')
        {
            return $data[0];
        }
        else
        {
            throw new FFmpegNotInstalledException("FFmpeg not found on this distribution. Need to set execPath manually.");
        }
    }
}