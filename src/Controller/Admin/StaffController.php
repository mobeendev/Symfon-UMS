<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Repository\AuthorRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/admin/staff", name="admin_staff_")
 */
class StaffController extends BaseController
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/staff/index.html.twig', [
            'controller_name' => 'StaffController',
        ]);
    }

}
