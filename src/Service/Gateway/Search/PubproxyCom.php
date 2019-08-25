<?php

namespace Service\Gateway\Search;

use Service\Downloader\Curl\DownloaderProxyService;

class PubproxyCom
{
    /**
     * @param null|string $country
     * @return array
     */
    public static function findProxy($country = null)
    {
        $url = 'http://pubproxy.com/api/proxy?format=json&proxy_level=anonymous';

        if (!is_null($country)) {
            $url .= '&country=' . strtoupper($country);
        }

        $downloader = new DownloaderProxyService($url, 'proxy');
        $downloader->download();

        $content = $downloader->getResponseContent();
        $content = json_decode($content, true);
        $content = @$content['data'][0];

        $protocol = [
            'http' => CURLPROXY_HTTP,
            'socks4' => CURLPROXY_SOCKS4,
            'socks4a' => CURLPROXY_SOCKS4A,
            'socks5' => CURLPROXY_SOCKS5,
            'socks5h' => CURLPROXY_SOCKS5_HOSTNAME,
        ];

        return [
            'ip' => @$content['ip'] ?? null,
            'port' => @$content['port'] ?? null,
            'socket_type' => @$protocol[@$content['type']] ?? null,
        ];
    }
}
