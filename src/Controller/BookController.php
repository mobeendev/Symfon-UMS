<?php

namespace App\Controller;

use App\Interfaces\BookRepositoryInterface;
use App\Repository\BookRepository;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/book", name="book_")
 * @IsGranted("ROLE_STUDENT")
 */
class BookController extends AbstractController
{
    private BookRepositoryInterface $bookRepository;
    private BookingService $bookingService;

    public function __construct(BookRepositoryInterface $bookRepository, BookingService $bookingService)
    {
        $this->bookRepository = $bookRepository;
        $this->bookingService = $bookingService;
    }

    /**
     * @Route("/borrow/{id}", name="borrow")
     */
    public function borrow($id = null): Response
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('The book does not exist');
        }

        if($this->bookingService->requestForBorrow($book, $this->getUser())){
            $this->addFlash('success', 'Account updated with success.');
        }

        $this->addFlash('error', 'Already reserved.');


        $books = $this->bookRepository->getAllAvailable();
        return $this->render('front/book/new-arrived.html.twig', [
            'books' => $books,
        ]);
    }
}
