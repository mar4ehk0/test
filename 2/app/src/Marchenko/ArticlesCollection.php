<?php

namespace Marchenko;

use Iterator;

class ArticlesCollection implements Iterator
{
    private int $pointer = 0;
    private int $total = 0;
    private array $objects = [];
    private array $raw = [];

    public function __construct(array $raw = [])
    {
        if (!empty($raw)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
    }

    public function add(Article $article): void
    {
        $this->objects[$this->total] = $article;
        $this->total++;
    }

    private function getRow(int $num): ?Article
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->createObject($this->raw[$num]);
            return $this->objects[$num];
        }

        return null;
    }

    private function createObject(array $raw): Article
    {
        return new Article(
            $raw['name'],
            $raw['group'],
            $raw['price'],
        );
    }

    public function current(): ?Article
    {
        return $this->getRow($this->pointer);
    }

    public function next(): ?Article
    {
        $this->pointer++;
        return $this->current();
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function valid(): bool
    {
        return (!is_null($this->current()));
    }

    public function rewind()
    {
        $this->pointer = 0;
    }
}