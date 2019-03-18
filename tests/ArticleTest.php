<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testIfWeCanSetTitleOfArticle()
    {
        $article = new Article();
        $article->setTitle('Article Title');


        $this->assertEquals($article->getTitle(), 'Article Title');
    }


    public function testIfWeCanSetBodyOfArticle()
    {
        $article = new Article();
        $article->setBody('Article Content');


        $this->assertEquals($article->getBody(), 'Article Content');
    }


    public function testIfWeCanSetCategoryOfArticle()
    {
        $article = new Article();

        $category = new Category();
        $category->setCategory("Testing");


        $article->setCategory($category->getId());

        $this->assertEquals($article->getCategory(), $category->getId());
    }

    public function testIfWeCanCreateCompleteArticleWithCategory()
    {
        $article  = new Article();
        $category = new Category();

        $category->setCategory("Testing");

        $article->setTitle("Testing Title");
        $article->setBody("Testing Body");
        $article->setCategory($category->getId());

        $this->assertEquals($article->getTitle(), "Testing Title");
        $this->assertEquals($article->getBody(), "Testing Body");
        $this->assertEquals($article->getCategory(), $category->getId());

    }
}
