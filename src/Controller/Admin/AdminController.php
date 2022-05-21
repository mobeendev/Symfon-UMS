<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookTag;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\TagRepository;
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

    #[Route('/book/form/{id}', name: 'book_form')]
    public function newBook(Request $request, TagRepository $tagRepository,BookRepository $bookRepository, $id = null): Response
    {   

        $book = new Book();
        $formInformation = [ 'header_label' => 'New Author', 'button_label' => 'Cancel' ];


        if (isset($id) && !empty($id)){
            $book = $bookRepository->find($id);
            $formInformation = [ 'header_label' => 'Update Class Pack', 'button_label' => 'Back' ];
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $this->em->persist($book);

            foreach($book->getBookTags() as $bookTag){

                $book->addBookTag($bookTag);
                $this->em->persist($book);
            }

            $this->em->flush();
            $this->addFlash('success', 'Book created with success.');
            return $this->redirectToRoute('admin_book');
        }
        // dd($form);

        // dd($form->createView());
        return $this->render('admin/book-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation
        ]);

    }

    #[Route('/book/form/edit/{id}', name: 'book_form_edit')]
    public function editBook(Request $request, TagRepository $tagRepository,BookRepository $bookRepository, $id = null): Response
    {
        $book = null;
        if (isset($id) && !empty($id)){
            $book = $bookRepository->find($id);
            $formInformation = [ 'header_label' => 'Update Class Pack', 'button_label' => 'Back' ];
        }


//        dd($book);

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($book);

            foreach($book->getBookTags() as $bookTag){

                $book->addBookTag($bookTag);
                $this->em->persist($book);
            }

            $this->em->flush();
            $this->addFlash('success', 'Book created with success.');
            return $this->redirectToRoute('admin_book');
        }
        // dd($form);

        // dd($form->createView());
        return $this->render('admin/book-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation
        ]);

    }



    #[Route('/author/form', name: 'author_form')]
    public function newAuthor(Request $request, AuthorRepository $authorRepository): Response
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $formInformation = [ 'header_label' => 'New Author', 'button_label' => 'Cancel' ];

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

//            dd($author);
//            $articleToUpdate = $authorRepository->find($articleActualise['id']);
//            if ($articleToUpdate === null) {
//                // Article does not exist so we need to create a new object
//            }



            $this->em->persist($author);
            $this->em->flush();
            $this->addFlash('success', 'Author created with success.');
            return $this->redirectToRoute('admin_author');
        }

        return $this->render('admin/author-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation,
        ]);
    }




    #[Route('/author', name: 'author')]
    public function author(AuthorRepository $authorRepository, BookRepository $bookRepository): Response
    {
        $authors = $authorRepository->getAuthor();
        $authorWithBooks = [];
//        dd($authors); ./

        foreach ($authors as $author){



            $authorWithBooks[$author['id']] = [
                'name' => $author['name'],
                'age' => $author['age'],
                'books' => $author['book'] ,
            ];

//            foreach ($author['book'] as $book){
//
//             }


//            $booksGroupByAuthor[$author->getId()][] = [];

//                foreach ($author['book'] as $book){
//
//                    if (!isset( $author['book']['id'] )){
//                        $author['book']['id'] =  $book;
//
//                    }
////                        dump($author);
//                }
//            dd($author);

//            dd($author->getBookTags());

//            $booksGroupByAuthor[$book->getAuthor()->getName()][] = $book;
        }

        dump($authorWithBooks);
//        dd($booksGroupByAuthor);

        return $this->render('admin/author.html.twig', [
            'authors' => $authors,
        ]);
    }


    #[Route('/book/borrowed', name: 'book_borrowed')]
    public function bookBorrowed(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

        foreach ($books as $book){

            $booksGroupByAuthor[$book->getAuthor()->getName()][] = $book;
        }
        return $this->render('admin/book-borrowed.html.twig', [
            'books' => $books,
        ]);
    }


    
    #[Route('/book', name: 'book')]
    public function book(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

        foreach ($books as $book){
        }
        return $this->render('admin/book.html.twig', [
            'books' => $books,
        ]);
    }

}
