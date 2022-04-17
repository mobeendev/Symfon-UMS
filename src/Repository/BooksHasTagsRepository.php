<?php

namespace App\Repository;

use App\Entity\BooksHasTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BooksHasTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method BooksHasTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method BooksHasTags[]    findAll()
 * @method BooksHasTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksHasTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BooksHasTags::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BooksHasTags $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BooksHasTags $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BooksHasTags[] Returns an array of BooksHasTags objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BooksHasTags
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
