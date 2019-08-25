<?php

namespace Service\Parser\IpApi;

use Service\Downloader\Curl\DownloaderProxyService;

class IpApiParser
{
    public static function run()
    {
        $downloader = new DownloaderProxyService("http://ip-api.com/json/", 'proxy');
        $downloader->download(true);

        $content = json_decode($downloader->getResponseContent(), true);

        echo "====================". PHP_EOL;
        foreach ($content as $k => $v) {
            echo "$k: $v" . PHP_EOL;
        }
        echo "====================". PHP_EOL;
    }
}
