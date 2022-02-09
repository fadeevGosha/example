<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository implements IArticleRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return array
     */
    public function findLatestPublished(): array
    {
        return $this->latest($this->published())
            ->addSelect('c')
            ->addSelect('t')
            ->leftJoin('a.comments', 'c')
            ->leftJoin('a.tags', 't')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findLatest(): array
    {
        return $this->latest()
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findPublished(): array
    {
        return $this->published()
            ->getQuery()
            ->getResult();
    }

    private function published(QueryBuilder $qb = null):QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)->andWhere('a.publishedAt is not null');
    }

    public function latest(QueryBuilder $qb = null):QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)->orderBy('a.publishedAt', 'DESC');
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(?QueryBuilder $qb): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');
    }
}
