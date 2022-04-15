<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends BaseController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    

    #[Route('/author/new', name: 'author_new')]
    public function newAuthor(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();
            $this->addFlash('success', 'Author created with success.');
            return $this->redirectToRoute('admin_author');
        }
        return $this->render('admin/new-author.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/author/edit/{id}', name: 'author_edit')]
    public function editAuthor(Request $request, AuthorRepository $authorRepository, $id): Response
    {
        $author = $authorRepository->find($id);
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();
            $this->addFlash('success', 'Author updated with success.');
            return $this->redirectToRoute('admin_author');
        }
        return $this->render('admin/edit-author.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('/author', name: 'author')]
    public function author(AuthorRepository $authorRepository, BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

        foreach ($books as $book){
            if (!isset($booksGroupByAuthor[$book->getAuthor()->getName()])){
                $booksGroupByAuthor[$book->getAuthor()->getName()] = [];
            }
            $booksGroupByAuthor[$book->getAuthor()->getName()][] = $book;
        }
//        dump($booksGroupByAuthor);
        return $this->render('admin/author.html.twig', [
            'books' => $booksGroupByAuthor,
        ]);
    }


    #[Route('/book/borrowed', name: 'book_borrowed')]
    public function bookBorrowed(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

        foreach ($books as $book){
            if (!isset($booksGroupByAuthor[$book->getAuthor()->getName()])){
                $booksGroupByAuthor[$book->getAuthor()->getName()] = [];
            }
            $booksGroupByAuthor[$book->getAuthor()->getName()][] = $book;
        }
        return $this->render('admin/book-borrowed.html.twig', [
            'books' => $booksGroupByAuthor,
        ]);
    }
    #[Route('/book', name: 'book')]
    public function book(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

        foreach ($books as $book){
            if (!isset($booksGroupByAuthor[$book->getAuthor()->getName()])){
                $booksGroupByAuthor[$book->getAuthor()->getName()] = [];
            }
            $booksGroupByAuthor[$book->getAuthor()->getName()][] = $book;
        }
//        dump($booksGroupByAuthor);
        return $this->render('admin/book.html.twig', [
            'books' => $booksGroupByAuthor,
        ]);
    }

    #[Route('/book/new', name: 'book_new')]
    public function newBook(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();
            $this->addFlash('success', 'Book created with success.');
            return $this->redirectToRoute('admin_book');
        }
        return $this->render('admin/new-book.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('/book/edit/{id}', name: 'book_edit')]
    public function editBook(Request $request, BookRepository $bookRepository, $id): Response
    {
        $book = $bookRepository->find($id);
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();
            $this->addFlash('success', 'Book updated with success.');
            return $this->redirectToRoute('admin_book');
        }
        return $this->render('admin/edit-book.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
