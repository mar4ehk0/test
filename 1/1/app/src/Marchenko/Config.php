<?php

namespace Marchenko;

use Exception;

class Config
{
    protected const ROOT_PATH = __DIR__ . '/../../config.yaml';

    /**
     * config.yaml has special struct
     * @see '/../../config.yaml'
     */
    protected const SECTION_SUFFIX = '_log_path';

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
        $this->data = self::load();
    }

    /**
     * @return mixed
     */
    public function getParam(string $sectionName, string $paramName = "")
    {
        $data = $this->getSection($sectionName);
        if (empty($data)) {
            return null;
        }

        if (empty($paramName)) {
            return $data;
        }

        if (!isset($data[$paramName])) {
            return null;
        }
        return $data[$paramName];
    }

    /**
     * @return mixed
     */
    private function getSection(string $sectionName)
    {
        if (!isset($this->data[$sectionName])) {
            return null;
        }

        return $this->data[$sectionName];
    }

    /**
     * @throws Exception
     */
    private function load(): array
    {
        return self::process(self::ROOT_PATH);
    }

    /**
     * @throws Exception
     */
    private function process(string $filePath): array
    {
        $data = [];

        foreach (self::readFile($filePath) as $varName => $varValue) {
            if (empty($varValue)) {
                throw new Exception('Config has empty variable "' . $varName . '"');
            }
            if (strpos($varName, self::SECTION_SUFFIX) !== false && file_exists($varValue)) {
                $varValue = self::process($varValue);
                $varName = str_replace(self::SECTION_SUFFIX, '', $varName);
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