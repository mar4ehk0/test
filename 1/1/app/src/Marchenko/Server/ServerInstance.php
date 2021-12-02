<?php

namespace Marchenko\Server;

use Marchenko\AppInstance;
use Symfony\Component\HttpFoundation\Response;

class ServerInstance extends AppInstance
{
    public function run()
    {
        try {
            $msgStatus = "was not executed";
            $status = $this->do();
            if ($status) {
                $msgStatus = "was executed";
            }
            $msg = "The command " . $msgStatus;
            $status = Response::HTTP_OK;
        }
        catch (\Exception $exception) {
            $msg = $exception->getMessage();
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new Response(
            $msg,
            $status,
            ['content-type' => 'text/html']
        );
        $response->send();
    }
}