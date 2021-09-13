<?php

namespace Marchenko\Command;

use Marchenko\Exception\CommandCreatorException;
use Marchenko\Models\Item;

class CommandCreator
{
    public static function create(string $commandType, Item $item): Command
    {
        switch ($commandType) {
            case 'add':
                $command = new AddCommand($item);
                break;
            case 'remove':
                $command = new RemoveCommand($item);
                break;
            default:
                throw new CommandCreatorException('Unsupported command');
        }

        return $command;
    }
}