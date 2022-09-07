<?php

namespace Marchenko;

use Marchenko\Storage\Storagable;
use Marchenko\Storage\StorageCreator;

class App
{
    private AppInstance $appInstance;
    private Validator $validator;
    private Param $param;
    private Storagable $storage;

    public function __construct()
    {
        $this->prepareConfig();
        $factory = AppCreator::getFactory(php_sapi_name());
        $this->param = $factory->createParam();
        $this->validator = new Validator();
        $this->storage = $this->getStorage();
        $this->appInstance = $factory->createInstance(
            $this->storage, $this->validator, $this->param
        );
    }

    private function prepareConfig(): void
    {
        (Config::getInstance())->create();
    }

    private function getStorage(): Storagable
    {
        $type = (Config::getInstance())->getParam('storage', 'type');
        return StorageCreator::create($type);
    }

    public function run()
    {
        $this->appInstance->run();
    }
}

