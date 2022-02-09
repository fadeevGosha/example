<?php


namespace App\Services;


interface IArticleService
{
    public function getArticles(): array;

    public function getRandArticle(): array;

    public function getArticleById(int $articleId): array;

    public function getArticleByIdWithoutParse(int $articleId): array;
}