<?php

namespace Marchenko\Command;

use Marchenko\Models\Item;
use Marchenko\Storage\Storagable;

abstract class Command
{
    protected Item $item;
    protected Storagable $storage;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    protected function getItem(): Item
    {
        return $this->item;
    }

    abstract public function execute(Storagable $storage): bool;
}