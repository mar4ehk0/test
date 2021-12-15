<?php

require __DIR__ . '/../vendor/autoload.php';

use Marchenko\App;
use Marchenko\View;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    View::showMessage($exception->getMessage());
}
