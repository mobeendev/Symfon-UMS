<?php

namespace App\Controller;

use App\Interfaces\BookRepositoryInterface;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/book", name="book")
     */
    public function book(): Response
    {
        $books = $this->bookRepository->getAllAvailable();
        return $this->render('front/book/new-arrived.html.twig', [
            'books' => $books,
        ]);
    }
}
