<?php

namespace App\Controller\Front;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Services\SlugService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_list")
     */
   
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('Front/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

}
