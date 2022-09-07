<?php

namespace Marchenko;

class Article
{
    private const EXCLUDE_GROUP = 0;

    private string $name;
    private int $group;
    private float $price;
    private string $id;

    public function __construct(string $name, int $group, float $price)
    {
        $this->name = $name;
        $this->group = $group;
        $this->price = $price;

        $this->setId();
    }

    private function setId(): void
    {
        $this->id = md5(mt_rand() . microtime());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroup(): int
    {
        return $this->group;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getId(): string
    {
        return $this->id;
    }

}