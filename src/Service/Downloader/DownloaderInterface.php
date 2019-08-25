<?php

namespace Service\Downloader;

interface DownloaderInterface
{
    public function download($is_proxy = false);
    public function getAlias();
    public function getResponses();
    public function getServiceName();
    public function getResponseHeaders();
    public function getResponseContent();
    public function getResponseCode();
}
