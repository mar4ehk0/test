<?php

class ArticleCollection implements Iterator
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

    /**
     * Adds object Article to Collection.
     *
     * @param Article $article
     */
    public function add(Article $article): void
    {
        $this->objects[$this->total] = $article;
        $this->total++;
    }

    /**
     * Returns object Article.
     *
     * @param int $num
     * @return Article|null
     */
    private function getRow(int $num): ?Article
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->createContentObject($this->raw[$num]);
            return $this->objects[$num];
        }

        return null;
    }

    /**
     * Creates object Article from array.
     *
     * @param array $raw
     * @return Article
     */
    private function createContentObject(array $raw): Article
    {
        return new Article(
            $raw['id'],
            $raw['title'],
            $raw['body'],
            $raw['userId'],
            $raw['created'],
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