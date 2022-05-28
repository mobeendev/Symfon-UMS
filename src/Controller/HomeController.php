<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{


    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


}
