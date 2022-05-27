<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookTag;
use App\Entity\Department;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Form\DepartmentType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CountryRepository;
use App\Repository\DepartmentRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends BaseController
{
    private Security $security;

    public function __construct(UserRepository $userRepository , Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;

    }
    /**
     * @Route("/", name="index")
     */
   public function index(): Response
    {
//        dd($this->getUser()->getRoles());

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/book/form/{id}", name="book_form")
     */
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

    /**
     * @Route("/book/form/edit/{id}", name="book_form_edit")
     */
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

    /**
     * @Route("/author/form", name="author_form")
     */
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




     /**
     * @Route("/author", name="author")
     */
    public function author(AuthorRepository $authorRepository, BookRepository $bookRepository, CountryRepository $countryRepository, Request $request): Response
    {
        $authors = $authorRepository->getAuthor($request);
        //dd($authors);

        //Search Filters
        $countries = $countryRepository->findAll();

        return $this->render('admin/author.html.twig', [
            'authors' => $authors,
            'countries' => $countries,
        ]);
    }


    /**
     * @Route("/book/borrowed", name="book_borrowed")
     */
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


    
     /**
     * @Route("/book", name="book")
     */
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

    /**
     * @Route("/department/form/{id}", name="department_form")
     */
    public function formDepartment(Request $request, DepartmentRepository $departmentRepository, $id = null): Response
    {
        $department = new Department();
        $formInformation = [ 'header_label' => 'New Department', 'button_label' => 'Cancel' ];
        $formIcon = null;

        if (isset($id) && !empty($id)){
            $department = $departmentRepository->find($id);
            $formInformation = [ 'header_label' => 'Update Department', 'button_label' => 'Back' ];
        }

        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($department);
            $this->em->flush();
            $this->addFlash('success', 'Department updated with success.');
        }

        return $this->render('admin/department-form.html.twig', [
            'form' => $form->createView(),
            'formIcon' => $formIcon != null ? $formIcon->createView() : '',
            'formInformation' => $formInformation
        ]);
    }

    /**
     * @Route("/department", name="department")
     */
    public function department(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->findBy([],['id'=>'desc']);

//        $books = $bookRepository->findAll();
        $booksGroupByAuthor = [];

//        dump($departments);
        $jsonDeparment = [];
        $jsonLocationCategories = [];
        $jsonCountries = [];

        foreach ($departments as $department) {
            $jsonDeparment[] = [
                'id' => $department->getId(),
                'name' => $department->getName(),
                'code' => $department->getCode(),
                'type' => 'Department',
            ];
        }

        $jsonDeparment = json_encode($jsonDeparment);

        dump($jsonDeparment);
        return $this->render('admin/department.html.twig', [
            'departments' => $jsonDeparment,
        ]);
    }
}
