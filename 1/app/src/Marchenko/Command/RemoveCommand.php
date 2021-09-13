<?php

namespace Marchenko\Command;

use Marchenko\Logger\AppLogger;
use Marchenko\Storage\Storagable;

class RemoveCommand extends Command
{

    public function execute(Storagable $storage): bool
    {
        $newItem = $this->getItem();
        $currentItem = $storage->find($newItem->getSku());
        if (!empty($currentItem)) {
            $conditionRemove = ($newItem->getQty() <= 0) ||
                ($currentItem->getQty() - $newItem->getQty() <= 0);
            if ($conditionRemove) {
                if ($storage->delete($newItem)) {
                    AppLogger::addInfo(
                        "Was deleted Item: " . $currentItem->getSku()
                    );
                    return true;
                }
            }
            if ($currentItem->getQty() != $newItem->getQty()) {
                $newQty = $currentItem->getQty() - $newItem->getQty();
                if ($storage->update($currentItem, $newQty)) {
                    AppLogger::addInfo(
                        "Was remove qty(-" . $newItem->getQty() . ") from item: "
                        . $newItem->getSku() . '. New qty:' . $newQty
                    );
                    return true;
                }
            }
        }

        return false;
    }
}