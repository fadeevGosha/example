<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository implements ICommentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }


    public function findAllWithSearch(?string $search, bool $isNeedSoftDeletableUsed = false, bool $isNeedReturnData = true)
    {
        $qb = $this->createQueryBuilder('c');

        if ($search)
        {
            $qb
                ->andWhere('c.content LIKE :search OR c.authorName LIKE :search OR a.title LIKE :search')
                ->setParameter('search', "%$search%");
        }

        if($isNeedSoftDeletableUsed)
        {
            $this->getEntityManager()->getFilters()->disable('softdeleteable');
        }

        $qb
            ->addSelect()
            ->innerJoin('c.article', 'a')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery();


        if($isNeedReturnData)
        {
            $result = $qb->getResult();
        }
        else
        {
            $result = $qb;
        }

        return $result;
    }

    public function findAllWithSearchQuery(?string $search, bool $isNeedSoftDeletableUsed = false):QueryBuilder
    {
        return $this->findAllWithSearch($search, $isNeedSoftDeletableUsed, false);
    }

    public function getCommentForArticleEdit(): array
    {
        $result = null;
        foreach ($this->findAll() AS $item)
        {
            $result[$item->getId()] = $item->getContent();
        }
        return $result;
    }
}
