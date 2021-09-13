<?php

namespace Marchenko;

use Marchenko\Console\ConsoleFactory;
use Marchenko\Exception\AppCreatorException;
use Marchenko\Server\ServerFactory;

class AppCreator
{
    public static function getFactory(string $type): AppFactory
    {
        switch ($type) {
            case 'cli':
                $factory = new ConsoleFactory();
                break;
            case 'fpm-fcgi':
                $factory = new ServerFactory();
                break;
            default:
                throw new AppCreatorException('Unsupported type interface.');
        }
        return $factory;
    }
}