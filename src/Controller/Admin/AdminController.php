<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
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

    #[Route('/author', name: 'author')]
    public function author(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        dump($authors);
        return $this->render('admin/author.html.twig', [
            'authors' => $authors,
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

}
