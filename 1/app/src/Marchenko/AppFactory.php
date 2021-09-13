<?php


namespace Marchenko;

use Marchenko\Storage\Storagable;

interface AppFactory
{
    public function createInstance(
        Storagable $storage,
        Validator $validator,
        Param $param
    ): AppInstance;
    public function createParam(): Param;
}
