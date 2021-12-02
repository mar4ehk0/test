<?php

namespace Marchenko\Server;

use Marchenko\Exception\ServerParamException;
use Marchenko\Param;
use Symfony\Component\HttpFoundation\Request;

class ServerParam extends Param
{
    public function __construct()
    {
        $request = Request::createFromGlobals();
        $this->data = $request->request->all();
    }

    public function getTypeCommand(): string
    {
        if (!isset($this->data['command'])) {
            throw new ServerParamException("Param 'command' was not set.");
        }
        return $this->data['command'];
    }

    public function getSku(): string
    {
        if (!isset($this->data['sku'])) {
            throw new ServerParamException("Param 'sku' was not set.");
        }
        return $this->data['sku'];
    }

    public function getQty(): string
    {
        if (!isset($this->data['qty'])) {
            throw new ServerParamException("Param 'qty' was not set.");
        }
        return $this->data['qty'];
    }
}