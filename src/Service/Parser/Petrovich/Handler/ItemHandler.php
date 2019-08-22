<?php

namespace Service\Parser\Petrovich\Handler;

class ItemHandler extends AbstractHandler implements InterfaceHandler
{
    public function run()
    {
        $page = $this->crawler->filter('.product_page');

        $title = $page
            ->filter('.product--title')
            ->getNode(0)
            ->nodeValue;

        $info = $page
            ->filter('.text--common')
            ->getNode(0)
            ->nodeValue;

        $price = $page
            ->filter('.retailPrice')
            ->getNode(0)
            ->nodeValue;

        $this->data[$title] = "($price)".PHP_EOL.$info;
    }
}
