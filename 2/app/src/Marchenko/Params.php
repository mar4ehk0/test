<?php

namespace Marchenko;

use Exception;
use Marchenko\Article;

class Params
{
    protected const ROOT_PATH = __DIR__ . '/../../input_params.yaml';

    private static ?Params $instance = null;
    private array $data;

    private function __construct() { }
    private function __clone() { }
    private function __wakeup() { }

    public static function getInstance(): Params
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
    public function get(): array
    {
        if (empty(file_exists(self::ROOT_PATH))) {
            throw new Exception(self::ROOT_PATH . ' does not exit.');
        }
        $this->data = $this->load();
        return $this->data;
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
            $condition = array_key_exists('name', $varValue) && is_string($varValue['name'])
                && array_key_exists('group', $varValue) && is_int($varValue['group'])
                && array_key_exists('price', $varValue) && is_numeric($varValue['price']);
            if ($condition) {
                $data[] = $varValue;
            }

        }
        return $data;
    }

    private function readFile(string $filePath): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($filePath);
    }

}