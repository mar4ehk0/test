<?php

namespace Marchenko;

class App
{
    private ArticlesCollection $articlesCollection;
    private Grouper $grouper;
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->prepareConfig();

        $this->createArticlesCollection();
        $this->createFilter();
    }

    private function prepareConfig(): void
    {
        (Config::getInstance())->create();
    }

    private function createArticlesCollection(): void
    {
        $params = $this->getParams();
        $this->articlesCollection = new ArticlesCollection($params);
    }

    /**
     * @throws \Exception
     */
    private function getParams(): array
    {
        return (Params::getInstance())->get();
    }

    private function createFilter(): void
    {
        $this->grouper = GrouperFactory::create((Config::getInstance())->getParam('grouper'));
    }

    public function run(): void
    {
        $articles = $this->grouper->do($this->articlesCollection);
        $sort = new Sort();
        $listSorted = $sort->do(
            $articles,
            (Config::getInstance())->getParam('sort'),
            (Config::getInstance())->getParam('sort_type')
        );
        foreach ($listSorted as $item) {
            View::showArticle($item);
        }
    }

}

