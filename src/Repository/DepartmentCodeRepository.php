<?php

namespace App\Repository;

use App\Entity\DepartmentCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepartmentCode>
 *
 * @method DepartmentCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartmentCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartmentCode[]    findAll()
 * @method DepartmentCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartmentCode::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DepartmentCode $entity, bool $flush = true): void
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
    public function remove(DepartmentCode $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return DepartmentCode[] Returns an array of DepartmentCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DepartmentCode
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
