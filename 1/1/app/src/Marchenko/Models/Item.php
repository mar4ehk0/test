<?php

namespace Marchenko\Models;

class Item
{
    private string $sku;
    private int $qty;

    public function __construct(string $sku, int $qty)
    {
        $this->sku = $sku;
        $this->qty = $qty;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

    public function getSku(): string
    {
        return strtoupper($this->sku);
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }
}