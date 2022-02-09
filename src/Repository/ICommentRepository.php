<?php


namespace App\Repository;


use Doctrine\ORM\QueryBuilder;

interface ICommentRepository
{
    public function findAllWithSearch(?string $search, bool $isNeedSoftDeletableUsed = false, bool $isNeedReturnData = true);

    public function findAllWithSearchQuery(?string $search, bool $isNeedSoftDeletableUsed = false):QueryBuilder;

    public function getCommentForArticleEdit(): array;
}