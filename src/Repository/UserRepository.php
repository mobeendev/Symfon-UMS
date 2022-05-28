<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function userHasRole($id ,$role) {
        // Entity manager
        $em= $this->getDoctrine()->getManager();
    $qb = $em->createQueryBuilder();

    $qb->select('u')
        ->from('userBundle:User', 'u') // Change this to the name of your bundle and the name of your mapped user Entity
        ->where('u.id = :user')
        ->andWhere('u.roles LIKE :roles')
        ->setParameter('user', $id)
        ->setParameter('roles', '%"' . $role . '"%');

        $user = $qb->getQuery()->getResult();

        if(count($user) >= 1){
            return true;
        }else{
            return false;
        }
    }
}
