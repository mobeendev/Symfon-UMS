<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/api", name="admin_api_")
 */
class APIsController extends BaseController
{

    public function __construct()
    {
    }


    /**
     * @Route("/authors", name="authors")
     */
    public function getUsersApi(Request $request, AuthorRepository $authorRepository): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {

            $query = $request->query->get('q', '');
            $users = $authorRepository->searchAuthor($query);

            if (!$users) {
                return new JsonResponse([
                    'sassign-roleuccess' => false,
                    'message' => 'Author(s) not found.',
                ], Response::HTTP_BAD_REQUEST);
            }

            return new JsonResponse(['success' => true, 'authors' => $users], Response::HTTP_OK);
        }

        return new JsonResponse(['success' => false,'message' => 'Bad Request',], Response::HTTP_BAD_REQUEST);
    }

}
