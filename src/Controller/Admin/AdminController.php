<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Country;
use App\Entity\Department;
use App\Entity\Tag;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Form\CountryType;
use App\Form\DepartmentType;
use App\Form\TagsType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CountryRepository;
use App\Repository\DepartmentRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends BaseController
{
    private Security $security;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository , Security $security)
    {
        parent::__construct($em);
        $this->userRepository = $userRepository;
        $this->security = $security;

    }
    /**
     * @Route("/", name="index")
     */
   public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/book/form/{id}", name="book_form")
     */
    public function bookForm(Request $request, TagRepository $tagRepository,BookRepository $bookRepository, $id = null): Response
    {
            $book = new Book();
            $formInformation = [ 'header_label' => 'New Author', 'button_label' => 'Cancel' ];

            if (isset($id) && !empty($id)){
                $book = $bookRepository->find($id);
                $formInformation = [ 'header_label' => 'Update Book', 'button_label' => 'Back' ];
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

            return $this->render('admin/book-form.html.twig', [
                'form' => $form->createView(),
                'formInformation' => $formInformation
            ]);

        }
    /**
     * @Route("/author/form/{id}", name="author_form")
     */
    public function authorForm(Request $request, AuthorRepository $authorRepository, $id = null): Response
    {
        $author = new Author();
        $formInformation = [ 'header_label' => 'New Author', 'button_label' => 'Cancel' ];

        if (isset($id) && !empty($id)){
            $author = $authorRepository->find($id);
            $formInformation = [ 'header_label' => 'Update Author', 'button_label' => 'Back' ];
        }

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();
            $this->addFlash('success', 'Author updated with success.');
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
     * @Route("/book", name="book", defaults={"page": "1"})
      * @Route("/book/page/{page}", name="book_paginated")
     */
    public function book(BookRepository $bookRepository, int $page = 1): Response
    {
        $booksListing = $bookRepository->getAllAvailable($page, $this->maxNbrPerPage);

        $paginationBookListing = [
            'page' => $page,
            'pagesNumber' => ceil(count($booksListing) / $this->maxNbrPerPage),
            'routeName' => 'admin_book_paginated',
            'routeParams' => [],
        ];

        return $this->render('admin/book.html.twig', [
            'books' => $booksListing,
            'pagination' => $paginationBookListing,
            'page' => $page,
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
            return $this->redirectToRoute('admin_department');
        }

        return $this->render('admin/department-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation
        ]);
    }

    /**
     * @Route("/department", name="department")
     */

    public function department(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->findBy([], ['id' => 'desc']);
        $jsonDeparment = [];

        foreach ($departments as $department) {
            $jsonDeparment[] = [
                'id' => $department->getId(),
                'name' => $department->getName(),
                'code' => $department->getCode(),
                'type' => 'Department',
            ];
        }

        $jsonDeparment = json_encode($jsonDeparment);

        return $this->render('admin/department.html.twig', [
            'departments' => $jsonDeparment,
        ]);
    }

    /**
     * @Route("/tag/form/{id}", name="tag_form")
     */
    public function tagForm(Request $request, TagRepository $tagRepository, $id = null): Response
    {
        $tag = new Tag();
        $formInformation = [ 'header_label' => 'New Tag', 'button_label' => 'Cancel' ];

        if (isset($id) && !empty($id)){
            $tag = $tagRepository->find($id);
            $formInformation = [ 'header_label' => 'Tag Department', 'button_label' => 'Back' ];
        }

        $form = $this->createForm(TagsType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagRepository->add($tag,true);
            $this->addFlash('success', 'Tag created with success.');

            return $this->redirectToRoute('admin_tag');
        }

        return $this->render('admin/tag-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation,
        ]);
    }

    /**
     * @Route("/tag", name="tag")
     */
    public function tag(TagRepository $tagRepository): Response
    {
        $tags = $tagRepository->findAll();

        return $this->render('admin/tag.html.twig', [
            'tags' => $tags,
        ]);
    }
    /**
     * @Route("/country/form/{id}", name="country_form")
     */
    public function formCountry(Request $request, CountryRepository $countryRepository, $id = null): Response
    {
        $country = new Country();
        $formInformation = [ 'header_label' => 'New Country', 'button_label' => 'Cancel' ];
        $formIcon = null;

        if (isset($id) && !empty($id)){
            $country = $countryRepository->find($id);
            $formInformation = [ 'header_label' => 'Update Country', 'button_label' => 'Back' ];
        }

        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($country);
            $this->em->flush();
            $this->addFlash('success', 'Country updated with success.');
            return $this->redirectToRoute('admin_country');
        }

        return $this->render('admin/country-form.html.twig', [
            'form' => $form->createView(),
            'formInformation' => $formInformation
        ]);
    }

    /**
     * @Route("/country", name="country")
     */
    public function country(CountryRepository $countryRepository): Response
    {
        $countries = $countryRepository->findBy([],['id'=>'desc']);
        $jsonCountries = [];

        foreach ($countries as $country) {
            $jsonCountries[] = [
                'id' => $country->getId(),
                'name' => $country->getName(),
                'code' => $country->getCode(),
                'phone_code' => $country->getPhoneCode(),
                'type' => 'Country',
            ];
        }

        $jsonCountries = json_encode($jsonCountries);

        return $this->render('admin/country.html.twig', [
            'countries' => $jsonCountries,
        ]);
    }
}
