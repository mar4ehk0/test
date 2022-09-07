<?php

namespace Marchenko;

class GroupedArticlesCollection
{
    private string $id;
    private ArticlesCollection $articlesCollection;

    public function __construct(string $id, ArticlesCollection $articlesCollection)
    {
        $this->id = $id;
        $this->articlesCollection = $articlesCollection;
    }

//    public function getId(): string
//    {
//        return $this->id;
//    }
//
    public function getArticlesCollection(): ArticlesCollection
    {
        return $this->articlesCollection;
    }

    public function addArticle(Article $article): void
    {
        $this->articlesCollection->add($article);
    }




}