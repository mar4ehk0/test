<?php

namespace Marchenko\Storage;

use Marchenko\Models\Item;

interface Storagable
{
    public function insert(Item $item): bool;
    public function update(Item $item, int $newQty): ?Item;
    public function find(string $sku): ?Item;
    public function delete(Item $item): bool;
}