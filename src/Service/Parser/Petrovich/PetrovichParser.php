<?php

namespace Service\Parser\Petrovich;

use Service\Downloader\DownloaderInterface;
use Service\Downloader\Curl\DownloaderProxyService;
use Service\Parser\Petrovich\Handler\InterfaceHandler;
use Service\Parser\Petrovich\Handler\ItemHandler;
use Service\Parser\Petrovich\Handler\ListItemsHandler;
use Service\Parser\Petrovich\Handler\MainHandler;
use Service\Parser\Petrovich\Handler\SubHandler;

class PetrovichParser
{
    /**
     * @var DownloaderInterface
     */
    private $downloader;

    protected $alias = 'Petrovich';

    public function run()
    {
        $mainUrl = 'https://petrovich.ru';
        $items = ['main' => $mainUrl];

        $handlers = [
            MainHandler::class,
            SubHandler::class,
            ListItemsHandler::class,
            ItemHandler::class,
        ];

        $i = 7;

        $recursivelyParse = function ($items, $handlers) use (&$recursivelyParse, $mainUrl, &$i) {

            if (empty($handlers)) {
                return;
            }

            $handler = array_shift($handlers);

            foreach ($items as $item => $url) {

                if (--$i < 0) {
                    return;
                }
                sleep(mt_rand(1, 3));

                $itemUrl = $mainUrl == $url ? $url : $mainUrl.$url;

                $this->downloader = new DownloaderProxyService($itemUrl, $this->alias);
                $this->downloader->download(true);

                if ($this->downloader->getResponseCode() !== 200) {
                    echo $this->downloader->getResponseCode().PHP_EOL;
                    return;
                }

                echo count($handlers) . ' ' . $item . PHP_EOL;

                $handler = is_string($handler) ? new $handler() : $handler;
                /**@var $handler InterfaceHandler */
                $handler->setDownloader($this->downloader);
                $handler->run();
                $handler->saveData();

                $data = $handler->getData();

                $recursivelyParse($data, $handlers);
            }
        };

        $recursivelyParse($items, $handlers);
    }
}
