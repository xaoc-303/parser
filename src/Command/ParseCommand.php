<?php

namespace Command;

use Service\Parser\Petrovich\PetrovichParser;

class ParseCommand
{
    public function execute()
    {
        echo date('Y-m-d H:i:s', time()) . PHP_EOL;

        $parse = new PetrovichParser();
        $parse->run();

        echo __METHOD__ . ' complete' . PHP_EOL;
    }
}
