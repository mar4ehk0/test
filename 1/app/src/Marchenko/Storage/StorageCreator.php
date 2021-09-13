<?php

namespace Marchenko\Storage;

use Marchenko\Exception\StorageException;

class StorageCreator
{
    public static function create(string $type): Storagable
    {
        switch ($type) {
            case 'xml':
                $storage = new XMLStorage();
                break;
            default:
                throw new StorageException('Unsupported Storage');
        }

        return $storage;
    }
}