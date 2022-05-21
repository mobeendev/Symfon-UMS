<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookTag;
use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function searchAuthor(string $patterns): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select("a.id as id, CONCAT(a.name, ' ',a.id) as displayName")
            ->from('App:Author', 'a');

        $qb
            ->where('a.name LIKE :query')
//            ->orWhere('up.age LIKE :query')
//            ->orWhere('up.email LIKE :query')
            ->setParameter('query', '%'.str_replace(' ', '%', strtolower($patterns)).'%')
            ->setMaxResults(10);

        return $qb->getQuery()->getArrayResult();
    }
    public function getAuthor()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('a.id, a.name, a.age, b as book')
            ->from('App:Author','a')
             ->leftJoin(
                    BookTag::class,
                    'bt',
                    \Doctrine\ORM\Query\Expr\Join::WITH,
                    'bt.author = a'
                )
            ->leftJoin(
                Book::class,
                'b',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'bt.book = b'
            )

            ->setMaxResults(100);

        return $qb->getQuery()->getArrayResult();


    }

    // /**
    //  * @return Author[] Returns an array of Author objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
