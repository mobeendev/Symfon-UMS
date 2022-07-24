<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\BookingRequest;
use App\Entity\User;
use App\Interfaces\BookingRequestRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookingRequest>
 *
 * @method BookingRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingRequest[]    findAll()
 * @method BookingRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRequestRepository extends ServiceEntityRepository implements BookingRequestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingRequest::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BookingRequest $entity, bool $flush = true): void
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
    public function remove(BookingRequest $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function isBookAvailable(Book $book, User $user)
    {
        return $this->createQueryBuilder('br')
            ->select('count(br.id)')
            ->andWhere('br.book = :book')
            ->andWhere('br.user = :user')
            ->setParameter('book', $book)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
