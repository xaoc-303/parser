<?php

namespace Service\Downloader;

abstract class DownloaderAbstractService implements DownloaderInterface
{
    protected $requestUrls;
    protected $requestHeaders;
    protected $responses;
    protected $responseHeaders;
    protected $responseContent;
    protected $serviceName;
    protected $responseCode;
    protected $alias;

    protected $client;

    public function __construct($urls, $alias)
    {
        $this->requestUrls = $urls;
        $this->alias = $alias;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    public function getResponseContent()
    {
        return $this->responseContent;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getRequestHeaders()
    {
        return [
            'Content-Type' => 'text/plain',
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
        ];
    }

    public function saveToFile($prefix = false, $timeExec = false)
    {
        $filename = is_string($prefix) ? $prefix.'-' : '';
        $filename .= microtime(true);
        //$filename .= '-' . (new \ReflectionClass($this->downloader))->getShortName();
        $filename .= '-' . $this->serviceName;
        $filename .= (is_numeric($timeExec)) ? '-' . $timeExec : '';

        file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . $filename . '.html', $this->responseContent);

        echo $filename . PHP_EOL;
    }
}
