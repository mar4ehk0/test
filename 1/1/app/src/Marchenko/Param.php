<?php

namespace Marchenko;

abstract class Param
{
    protected ?array $data;

    abstract public function getTypeCommand(): string;
    abstract public function getSku(): string;
    abstract public function getQty(): string;
}