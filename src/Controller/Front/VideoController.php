<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/video/home", name="video_home")
     */
    public function index(): Response
    {
        return $this->render('Front/video/index.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }
}
