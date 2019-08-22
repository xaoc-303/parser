<?php

namespace Service\Downloader\ReactPhp;

use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use Service\Downloader\DownloaderAbstractService;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'ReactPhp';

    public function download()
    {
        $loop = Factory::create();
        $client = new Browser($loop);

        $headers = [
            'Content-Type' => 'text/plain',
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10',
        ];

        $client->get($this->requestUrls, $headers)->then(function (ResponseInterface $response) {
            file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', (string)$response->getBody());
            $this->responseHeaders = $response->getHeaders();
            $this->responseContent = (string)$response->getBody();
            $this->responseCode = $response->getStatusCode();
        });

        $loop->run();
    }
}
