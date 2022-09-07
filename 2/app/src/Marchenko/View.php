<?php

namespace Marchenko;

class View
{
    public static function showArticle(Article $article): void
    {
        echo 'Name: '. $article->getName() . '| Group: '
            . $article->getGroup() . '| Price:'
            . $article->getPrice() . PHP_EOL;
    }

    public static function showMessage(string $msg): void
    {
        echo $msg . PHP_EOL;
    }

}