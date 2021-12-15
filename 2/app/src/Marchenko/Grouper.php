<?php

namespace Marchenko;

abstract class Grouper
{

    public function do(ArticlesCollection $articlesCollection): array
    {
        $groupedArticlesCollections = $this->group($articlesCollection);
        return $this->combine($groupedArticlesCollections);
    }

    abstract protected function group(ArticlesCollection $articlesCollection): array;

    abstract protected function combine(array $groupedArticlesCollections): array;

}