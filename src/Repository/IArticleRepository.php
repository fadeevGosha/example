<?php


namespace App\Repository;


use Doctrine\ORM\QueryBuilder;

interface IArticleRepository
{
    public function findLatestPublished(): array;

    public function findLatest(): array;

    public function findPublished(): array;

    public function latest(QueryBuilder $qb = null):QueryBuilder;
}