<?php

namespace Service\Gateway;

use Service\Gateway\Search\GetproxylistCom;
use Service\Gateway\Search\PubproxyCom;
use Service\Parser\IpApi\IpApiParser;

class GatewayService extends GatewayServiceSingle
{
    private $ip = null;
    private $port = null;
    private $socket_type = null;

    /**
     * @param null|string $country
     */
    protected function findProxy($country = null)
    {
        $content = GetproxylistCom::findProxy($country);

        if (!$content['ip']) {
            $content = PubproxyCom::findProxy($country);
        }

        $this->ip = $content['ip'];
        $this->port = $content['port'];
        $this->socket_type = $content['socket_type'];
    }

    /**
     * @param $country
     * @return GatewayResponseInterface
     */
    public function getDataObject($country)
    {
        if (is_null($this->ip)) {
            $this->findProxy($country);

            IpApiParser::run();
        }

        echo "proxy: {$this->ip}:{$this->port} ({$this->socket_type})". PHP_EOL;

        return (object) [
            'ip' => $this->ip,
            'port' => $this->port,
            'socket_type' => $this->socket_type,
        ];
    }
}
