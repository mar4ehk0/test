<?php

namespace Marchenko\Command;

use Marchenko\Logger\AppLogger;
use Marchenko\Storage\Storagable;

class AddCommand extends Command
{
    public function execute(Storagable $storage): bool
    {
        $newItem = $this->getItem();
        if ($newItem->getQty() == 0) {
            return false;
        }
        $currentItem = $storage->find($newItem->getSku());
        if (empty($currentItem)) {
            if ($newItem->getQty() > 0) {
                if ($storage->insert($newItem)) {
                    AppLogger::addInfo(
                        "Was inserted new Item: " . $newItem->getSku()
                        . ', qty:' . $newItem->getQty()
                    );
                    return true;
                }
            }
        }
        else {
            $newQty = $currentItem->getQty() + $newItem->getQty();
            if ($storage->update($currentItem, $newQty)) {
                AppLogger::addInfo(
                    "Was added qty(+" . $newItem->getQty() . ") to item: "
                    . $newItem->getSku() . '. New qty:' . $newQty
                );
                return true;
            }
        }
        return false;
    }
}