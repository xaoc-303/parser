<?php

namespace Service\Parser\Petrovich\Handler;

use Symfony\Component\DomCrawler\Crawler;

class SubHandler extends AbstractHandler implements InterfaceHandler
{
    public function run()
    {
        $this->crawler
            ->filter('ul.categories_list > li.categories_list_item > a > p.categories_list_item_name')
            ->each(function (Crawler $crawler) {
                $node = $crawler->getNode(0);
                $this->data[$node->nodeValue] = $node->parentNode->getAttribute('href');
            });
    }
}
