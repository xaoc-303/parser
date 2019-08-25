<?php

namespace Service\Downloader;

abstract class DownloaderProxyAbstract implements DownloaderInterface
{
    /**
     * @var DownloaderInterface
     */
    protected $downloader;

    protected $timeStart;
    protected $timeStop;

    public function download($is_proxy = false)
    {
        $this->timeStart();
        $this->downloader->download($is_proxy);
        $this->timeStop();

        echo microtime(true);
        //echo '-' . (new \ReflectionClass($this->downloader))->getShortName();
        echo ' ' . $this->downloader->getServiceName();
        echo ' ' . $this->getTimeExec();
        echo ' ' . $this->downloader->getAlias();
        echo PHP_EOL;
    }

    public function saveToFile($prefix = false)
    {
        $this->downloader->saveToFile($prefix, $this->getTimeExec());
    }

    protected function timeStart()
    {
        $this->timeStart = microtime(true);
    }

    protected function timeStop()
    {
        $this->timeStop = microtime(true);
    }

    protected function getTimeExec()
    {
        return round($this->timeStop - $this->timeStart, 4);
    }

    public function getAlias()
    {
        return $this->downloader->getAlias();
    }

    public function getResponses()
    {
        return $this->downloader->getResponses();
    }

    public function getServiceName()
    {
        return $this->downloader->getServiceName();
    }

    public function getResponseHeaders()
    {
        return $this->downloader->getResponseHeaders();
    }

    public function getResponseContent()
    {
        return $this->downloader->getResponseContent();
    }

    public function getResponseCode()
    {
        return $this->downloader->getResponseCode();
    }
}
