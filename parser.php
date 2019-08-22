<?php

use Command\ParseCommand;

set_time_limit(0);
ini_set('memory_limit', '512M');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';

define('PATH_STORAGE', __DIR__ . DIRECTORY_SEPARATOR . 'storage');

$options = getopt("", ['parse::']);

if (isset($options['parse'])) {
    $command = new ParseCommand();
    $command->execute();
}
