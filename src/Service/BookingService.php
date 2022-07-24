<?php


namespace App\Service;


use App\Entity\BookingRequest;
use App\Entity\Borrow;
use App\Interfaces\BookingRequestRepositoryInterface;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\BorrowRepositoryInterface;
use App\Repository\BookingRequestRepository;
use App\Repository\BorrowRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookingService
{
    private $em;
    private BookRepositoryInterface $bookRepository;
    private BookingRequestRepositoryInterface $bookingRequestRepository;

    public function __construct(EntityManagerInterface $em, BookRepositoryInterface $bookRepository, BookingRequestRepositoryInterface $bookingRequestRepository)
    {
        $this->em = $em;
        $this->bookRepository = $bookRepository;
        $this->bookingRequestRepository = $bookingRequestRepository;
    }

    public function requestForBorrow($book,$user)
    {
        $borrowRequest = new BookingRequest();
        $borrowRequest->setBook($book);
        $borrowRequest->setUser($user);
        $borrowRequest->setRequestDate(new \DateTime());
        $this->em->persist($borrowRequest);
        $this->em->flush();

        return true;
    }

    public function checkIfAvailable($book,$user)
    {
        return $this->bookingRequestRepository->isBookAvailable($book,$user);
    }
}