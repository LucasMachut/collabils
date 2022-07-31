<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_list")
     */
    public function list(): Response
    {
        return $this->render('Front/category/list.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
