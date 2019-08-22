<?php

namespace Service\Downloader\Curl;

use Curl\Curl;
use Service\Downloader\DownloaderAbstractService;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'Curl';

    public function download()
    {
        $headers = [
            'Content-Type' => 'text/plain',
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
        ];

        $client = new Curl();
        $client->setHeaders($headers);
        $client->get($this->requestUrls);

        file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', $client->getResponse());

        $this->responseCode = $client->getHttpStatusCode();
        $this->responseHeaders = $client->getResponseHeaders();
        $this->responseContent = $client->getResponse();

        $client->close();
    }
}
