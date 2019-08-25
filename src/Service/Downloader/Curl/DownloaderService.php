<?php

namespace Service\Downloader\Curl;

use Curl\Curl;
use Service\Downloader\DownloaderAbstractService;
use Service\Gateway\GatewayService;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'Curl';

    /**
     * @var Curl
     */
    protected $client;

    protected function setProxy()
    {
        $gateway = GatewayService::getInstance();
        $proxy = $gateway->getDataObject('RU');

        $this->client->setProxy($proxy->ip, $proxy->port);

        if (!is_null($proxy->socket_type)) {
            $this->client->setProxyType($proxy->socket_type);
        }

        $this->client->setOpt(CURLOPT_FOLLOWLOCATION, true);
    }

    public function download($is_proxy = false)
    {
        $this->client = new Curl();
        if ($is_proxy) {
            $this->setProxy();
        }
        $this->client->setHeaders($this->getRequestHeaders());
        $this->client->get($this->requestUrls);

        $this->responseCode = $this->client->getHttpStatusCode();
        $this->responseHeaders = $this->client->getResponseHeaders();
        $this->responseContent = $this->client->getRawResponse();

        file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', $this->responseContent);

        $this->client->close();
    }
}
