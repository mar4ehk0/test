<?php

namespace Marchenko\Console;

use Marchenko\Exception\ConsoleParamException;
use Marchenko\Param;
use Symfony\Component\HttpFoundation\Request;

class ConsoleParam extends Param
{
    public function __construct()
    {
        $request = Request::createFromGlobals();
        $this->data = $request->server->all('argv');
    }

    public function getTypeCommand(): string
    {
        if (!isset($this->data[1])) {
            throw new ConsoleParamException("Param 'command' was not set.");
        }
        return $this->data[1];
    }

    public function getSku(): string
    {
        if (!isset($this->data[2])) {
            throw new ConsoleParamException("Param 'sku' was not set.");
        }
        return $this->data[2];
    }

    public function getQty(): string
    {
        if (!isset($this->data[3])) {
            throw new ConsoleParamException("Param 'qty' was not set.");
        }
        return $this->data[3];
    }
}