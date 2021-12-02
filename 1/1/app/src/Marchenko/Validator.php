<?php

namespace Marchenko;

use Marchenko\Exception\ValidatorException;

class Validator
{
    protected array $allowedCommands;

    public function __construct()
    {
        $this->allowedCommands = (Config::getInstance())->getParam("allowed_commands");
    }

    public function validate(Param $param)
    {
        $typeCommand = $param->getTypeCommand();
        $sku = $param->getSku();
        $qty = $param->getQty();

        // не пуст каждый элемент


        if (!$this->checksCommand($typeCommand)) {
            throw new ValidatorException("Unknown command.");
        }
        if (!$this->qtyIsNumeric($qty)) {
            throw new ValidatorException("Parameter quantity is not a number.");
        }
        if ($this->qtyIsInteger($qty)) {
            throw new ValidatorException("Parameter quantity must be an integer.");
        }
    }

    private function checksCommand(string $command): bool
    {
        return in_array($command, $this->allowedCommands);
    }

    private function qtyIsNumeric($qty): bool
    {
        return is_numeric($qty);
    }

    private function qtyIsInteger($qty): bool
    {
        return ($qty != 0 && !intval($qty));
    }

}