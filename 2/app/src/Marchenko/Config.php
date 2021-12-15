<?php

namespace Marchenko;

use Exception;

class Config
{
    protected const ROOT_PATH = __DIR__ . '/../../config.yaml';

    private static ?Config $instance = null;
    private array $data;

    private function __construct() { }
    private function __clone() { }
    private function __wakeup() { }

    public static function getInstance(): Config
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
    public function create(): void
    {

        if (empty(file_exists(self::ROOT_PATH))) {
            throw new Exception(self::ROOT_PATH . ' does not exit.');
        }
        $this->data = $this->load();
    }

    /**
     * @return mixed
     */
    public function getParam(string $paramName)
    {
        if (!isset($this->data[$paramName])) {
            throw new Exception('Variable does not set.');
        }

        if (empty($paramName)) {
            return null;
        }

        return $this->data[$paramName];
    }


    /**
     * @throws Exception
     */
    private function load(): array
    {
        return $this->process(self::ROOT_PATH);
    }

    /**
     * @throws Exception
     */
    private function process(string $filePath): array
    {
        $data = [];

        foreach ($this->readFile($filePath) as $varName => $varValue) {
            if (empty($varValue)) {
                throw new Exception('Config has empty variable "' . $varName . '"');
            }
            $data[$varName] = $varValue;
        }
        return $data;
    }

    private function readFile(string $filePath): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($filePath);
    }

}