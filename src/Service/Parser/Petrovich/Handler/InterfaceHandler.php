<?php

namespace Service\Parser\Petrovich\Handler;

use Service\Downloader\DownloaderInterface;

interface InterfaceHandler
{
    public function run();
    public function setDownloader(DownloaderInterface $downloader);
    public function getData();
    public function saveData();
}