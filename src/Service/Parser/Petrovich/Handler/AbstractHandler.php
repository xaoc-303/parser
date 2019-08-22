<?php

namespace Service\Parser\Petrovich\Handler;

use Service\Downloader\DownloaderInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractHandler
{
    /**
     * @var DownloaderInterface
     */
    protected $downloader;

    /**
     * @var Crawler
     */
    protected $crawler;

    protected $data;
    protected $alias = 'Petrovich';

    public function setDownloader(DownloaderInterface $downloader)
    {
        $this->downloader = $downloader;
        $this->crawler = new Crawler($this->downloader->getResponseContent());
        $this->data = [];
    }

    public function getData()
    {
        return $this->data;
    }

    public function saveData()
    {
        $filename  = PATH_STORAGE;
        $filename .= DIRECTORY_SEPARATOR . $this->alias;
        $filename .= '.' . microtime(true);
        $filename .= '.' . (new \ReflectionClass($this))->getShortName() .'.json';

        $data = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

        file_put_contents($filename, $data);
    }
}
