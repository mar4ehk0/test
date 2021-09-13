<?php

require __DIR__ . '/../vendor/autoload.php';

use Marchenko\App;
use Marchenko\Logger\AppLogger;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    AppLogger::addError($exception->getMessage());
}
