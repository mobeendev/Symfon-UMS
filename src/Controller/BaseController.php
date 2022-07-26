<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class BaseController extends AbstractController
{
    protected $em;
    protected $maxNbrPerPage = 2;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
