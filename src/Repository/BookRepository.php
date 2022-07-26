<?php

namespace App\Repository;

use App\Interfaces\BookRepositoryInterface;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository implements BookRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getAllAvailable($page = 1, int $maxResults)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b')
            ->andWhere('b.isBooked IS NULL')
            ->orWhere('b.isBooked = 0')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
            ;

        $paginator = new Paginator($qb);

        if (($paginator->count() <= $maxResults) && 1 != $page) {
            return [];
        }

        return $paginator;
    }

    public function isBookAvailable($id)
    {
        return $id;
    }

    public function getBookByType(string $type = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('b')
            ->from('App:Book', 'b')
            ->leftJoin(
                'App:BookingRequest',
                'br',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'br.book = b'
            );

        if (isset($type) && !empty($type))
        {
            $status = null;
            switch ($type) {
                case 'requested':
                    $status = Book::STATUS_REQUESTED;
                    break;
                case 'rented':
                    $status = Book::STATUS_RENTED;
                    break;
                case 'returned':
                    $status = Book::STATUS_RETURNED;
                    break;
            }
            $qb->andWhere('br.status = :status')->setParameter('status', $status);
        }


//            ->andWhere('br.status = 1');

        return $qb->getQuery()->getResult();
    }

    public function getRequested()
    {
        // TODO: Implement getRequested() method.
    }
}
