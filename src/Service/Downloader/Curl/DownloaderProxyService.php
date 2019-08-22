<?php

namespace Service\Downloader\Curl;

use Service\Downloader\DownloaderProxyAbstract;

class DownloaderProxyService extends DownloaderProxyAbstract
{
    public function __construct($urls, $alias)
    {
        $this->downloader = new DownloaderService($urls, $alias);
    }
}
