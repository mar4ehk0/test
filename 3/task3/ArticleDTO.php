<?php

class ArticleDTO
{
    public string $title;
    public string $body;
    public int $userId;
    public int $created;

    /**
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


}