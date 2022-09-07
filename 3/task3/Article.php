<?php

class Article
{
    private int $id;
    private string $title;
    private string $body;
    private int $userId;
    private int $created;

    /**
     * @param int $id
     * @param string $title
     * @param string $body
     * @param int $userId
     * @param int $created
     */
    public function __construct(int $id, string $title, string $body, int $userId, int $created)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->userId = $userId;
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @param int $created
     */
    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

    /**
     * Returns authors Id.
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }



}