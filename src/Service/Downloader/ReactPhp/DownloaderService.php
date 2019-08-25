<?php

namespace Service\Downloader\ReactPhp;

use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Service\Downloader\DownloaderAbstractService;
use Service\Gateway\GatewayService;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'ReactPhp';

    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var Browser
     */
    protected $client;

    protected function setProxy()
    {
        $gateway = GatewayService::getInstance();
        $proxy = $gateway->getDataObject('RU');

        //todo: set proxy
    }

    public function download($is_proxy = false)
    {
        $this->loop = Factory::create();
        $this->client = new Browser($this->loop);
        if ($is_proxy) {
            $this->setProxy();
        }

        $this->client->get($this->requestUrls, $this->getRequestHeaders())->then(function (ResponseInterface $response) {
            $this->responseHeaders = $response->getHeaders();
            $this->responseContent = (string)$response->getBody();
            $this->responseCode = $response->getStatusCode();

            file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', (string)$response->getBody());
        });

        $this->loop->run();
    }
}
