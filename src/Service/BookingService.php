<?php


namespace App\Service;


use App\Entity\BookingRequest;
use App\Entity\Borrow;
use App\Interfaces\BookRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class BookingService
{
    private $em;
    private BookRepositoryInterface $bookRepository;

    public function __construct(EntityManagerInterface $em, BookRepositoryInterface $bookRepository)
    {
        $this->em = $em;
        $this->bookRepository = $bookRepository;
    }

    public function requestForBorrow($book,$user)
    {
        if($book->getIs)
        $borrowRequest = new BookingRequest();
        $borrowRequest->setBook($book);
        $borrowRequest->setUser($user);
        $borrowRequest->setRequestDate(new \DateTime());
        $this->em->persist($borrowRequest);

        return $this->em->flush();
    }
}