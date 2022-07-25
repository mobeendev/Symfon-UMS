<?php

namespace App\Controller;

use App\Interfaces\BookRepositoryInterface;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/student", name="student_")
 * @IsGranted("ROLE_STUDENT")
 */
class StudentController extends AbstractController
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/books", name="books")
     */
    public function book(): Response
    {
        $books = $this->bookRepository->getAllAvailable();
        return $this->render('front/book/new-arrived.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * @Route("/books/{type}", name="books_type")
     */
    public function rentedBooks(Request $request, string $type): Response
    {

        $books = $this->bookRepository->getBookByType($type);

        return $this->render('front/book/index.html.twig', [
            'books' => $books,
            'type' => $type,
        ]);
    }

    /**
     * @Route("/borrow/{id}", name="borrow")
     */
    public function borrow($id = null): Response
    {
        $user = $this->bookRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }

        dd('process');
        $books = $this->bookRepository->getAllAvailable();
        return $this->render('front/book/new-arrived.html.twig', [
            'books' => $books,
        ]);
    }
}
