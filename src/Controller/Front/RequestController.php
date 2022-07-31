<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestController extends AbstractController
{
    /**
     * @Route("/request", name="app_request")
     */
    public function index(): Response
    {
        return $this->render('Front/request/index.html.twig', [
            'controller_name' => 'RequestController',
        ]);
    }
}
