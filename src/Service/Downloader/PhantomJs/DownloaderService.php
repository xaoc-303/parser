<?php

namespace Service\Downloader\PhantomJs;

use Service\Downloader\DownloaderAbstractService;
use JonnyW\PhantomJs\Client;

class DownloaderService extends DownloaderAbstractService
{
    protected $serviceName = 'PhantomJs';

    public function download()
    {
        $client = Client::getInstance();
        $client->isLazy();

        $headers = [
            'Accept' => 'text/html',
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/7.0.540.0 Safari/534.10'
        ];

        /**
         * @see JonnyW\PhantomJs\Http\Request
         **/
        $request = $client->getMessageFactory()->createRequest($this->requestUrls, 'GET');
        //$request->setTimeout(10000);
        //$request->setDelay(15);

        /**
         * @see JonnyW\PhantomJs\Http\Response
         **/
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        file_put_contents(PATH_STORAGE . DIRECTORY_SEPARATOR . microtime(true).'.'.$this->getServiceName().'.html', $response->getContent());

        $this->responseContent = $response->getContent();
        $this->responseHeaders = $response->getHeaders();
        $this->responseCode = $response->getStatus();
    }
}
