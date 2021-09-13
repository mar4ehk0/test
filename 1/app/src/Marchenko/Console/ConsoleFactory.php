<?php

namespace Marchenko\Console;

use Marchenko\AppFactory;
use Marchenko\AppInstance;
use Marchenko\Param;
use Marchenko\Storage\Storagable;
use Marchenko\Validator;

class ConsoleFactory implements AppFactory
{

    public function createInstance(Storagable $storage, Validator $validator, Param $param): AppInstance
    {
        return new ConsoleInstance($storage, $validator, $param);
    }

    public function createParam(): Param
    {
        return new ConsoleParam();
    }
}