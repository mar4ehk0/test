<?php

namespace Marchenko;

class GrouperDefault extends Grouper
{
    private const NOT_COMBINE_GROUP = 0;

    public function group(ArticlesCollection $articlesCollection): array
    {
        $result = [];
        foreach ($articlesCollection as $article) {
            if (is_null($article)) {
                continue;
            }

            if ($article->getGroup() == self::NOT_COMBINE_GROUP) {
                $collection = new ArticlesCollection([]);
                $collection->add($article);
                $result[$article->getId()] = new GroupedArticlesCollection($article->getId(), $collection);
                continue;
            }
            if (isset($result[$article->getGroup()])) {
                $result[$article->getGroup()]->addArticle($article);
            }
            else {
                $collection = new ArticlesCollection([]);
                $collection->add($article);
                $result[$article->getGroup()] = new GroupedArticlesCollection($article->getGroup(), $collection);
            }
        }

        return $result;
    }

    public function combine(array $groupedArticlesCollections): array
    {
        $result = [];

        foreach ($groupedArticlesCollections as $collection) {
            $names = [];
            $price = 0;
            $group = 0;
            foreach ($collection->getArticlesCollection() as $article) {
                $names[] = $article->getName();
                $price += $article->getPrice();
                $group = $article->getGroup();
            }
            $result[] = new Article($this->getName($names), $group, $price);
        }
        return $result;
    }

    private function getName(array $names): string
    {
        return implode(', ', array_unique($names));
    }
}