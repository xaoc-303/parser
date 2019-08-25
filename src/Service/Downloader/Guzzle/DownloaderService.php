<?php

namespace Service\Downloader\Guzzle;

use GuzzleHttp\Client;
use Service\Downloader\DownloaderAbstractService;
use Service\Gateway\GatewayService;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'Guzzle';

    /**
     * @var Client
     */
    protected $client;

    protected function getProxy()
    {
        $gateway = GatewayService::getInstance();
        $proxy = $gateway->getDataObject('RU');

        $protocol = [
            'http' => CURLPROXY_HTTP,
            'socks4' => CURLPROXY_SOCKS4,
            'socks4a' => CURLPROXY_SOCKS4A,
            'socks5' => CURLPROXY_SOCKS5,
            'socks5h' => CURLPROXY_SOCKS5_HOSTNAME,
        ];

        $type = array_search($proxy->socket_type, $protocol);

        return "$type://{$proxy->ip}:$proxy->port";
    }

    public function download($is_proxy = false)
    {
        $this->client = new Client();

        $options = [
            'headers' => $this->getRequestHeaders(),
            'proxy' => $is_proxy ? $this->getProxy() : null,
        ];

        $response = $this->client->get($this->requestUrls, $options);

        $this->responseCode = $response->getStatusCode();
        $this->responseHeaders = $response->getHeaders();
        $this->responseContent = $response->getBody()->getContents();

        file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', $this->responseContent);
    }
}
