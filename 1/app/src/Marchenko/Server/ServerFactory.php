<?php

namespace Marchenko\Server;

use Marchenko\AppFactory;
use Marchenko\Param;
use Marchenko\Storage\Storagable;
use Marchenko\Validator;
use Marchenko\AppInstance;

class ServerFactory implements AppFactory
{

    public function createInstance(Storagable $storage, Validator $validator, Param $param): AppInstance
    {
        return new ServerInstance($storage, $validator, $param);
    }

    public function createParam(): Param
    {
        return new ServerParam();
    }
}