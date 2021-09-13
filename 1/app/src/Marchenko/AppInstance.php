<?php


namespace Marchenko;

use Marchenko\Command\CommandCreator;
use Marchenko\Models\Item;
use Marchenko\Storage\Storagable;

abstract class AppInstance
{

    protected Storagable $storage;
    protected Param $param;
    protected Validator $validator;

    public function __construct(Storagable $storage, Validator $validator, Param $param)
    {
        $this->param = $param;
        $this->validator = $validator;
        $this->storage = $storage;
    }

    final protected function do()
    {
        $this->validator->validate($this->param);
        $command = CommandCreator::create(
            $this->param->getTypeCommand(),
            new Item($this->param->getSku(), $this->param->getQty())
        );
        return $command->execute($this->storage);
    }

    abstract public function run();
}