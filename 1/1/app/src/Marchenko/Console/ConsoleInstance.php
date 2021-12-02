<?php

namespace Marchenko\Console;

use Marchenko\AppInstance;

class ConsoleInstance extends AppInstance
{
    public function run()
    {
        try {
            $msgStatus = "was not executed";
            $status = $this->do();
            if ($status) {
                $msgStatus = "was executed";
            }
            $this->showMessage("The command " . $msgStatus);
        }
        catch (\Exception $exception) {
            $this->showMessage($exception->getMessage());
        }
    }

    private function showMessage(string $msg): void
    {
        echo $msg . PHP_EOL;
    }
}