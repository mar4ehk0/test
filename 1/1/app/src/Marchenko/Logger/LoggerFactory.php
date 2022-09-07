<?php


namespace Marchenko\Logger;

use Marchenko\Config;
use Marchenko\Exception\LoggerFactoryException;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class LoggerFactory
{
    private static ?LoggerFactory $instance = null;

    private string $nameChannel;
    private string $type;
    private string $filePath;

    private function __construct() { }
    private function __clone() { }
    private function __wakeup() { }

    public static function getInstance(): LoggerFactory
    {
        if (static::$instance != null) {
            return static::$instance;
        }
        static::$instance = new static();
        return static::$instance;
    }

    /**
     * @throws Exception
     */
    public function getLog()
    {
        $this->loadConfigParam();
        $log = new Logger($this->nameChannel);
        $log->pushHandler($this->getHandler($this->type));
        return $log;
    }

    /**
     * @throws LoggerFactoryException
     */
    private function getHandler(string $type): HandlerInterface
    {
        switch ($type) {
            case 'file':
                $handler = new StreamHandler($this->filePath);
                break;
            default: throw new LoggerFactoryException();
        }

        return $handler;
    }

    private function loadConfigParam()
    {
        $config = Config::getInstance();
        $this->nameChannel = $config->getParam('log', 'name_channel');
        $this->type = $config->getParam('log', 'type');
        $this->filePath = $config->getParam('log', 'file_path');
    }

}
