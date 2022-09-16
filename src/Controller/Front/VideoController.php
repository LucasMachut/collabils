<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraint\NotBlank;
use Symfony\Component\Validator\Constraint\Type;


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
    /**
     * @Route("/video/submit", name="video_submit")
     */
    public function submit(): Response
    {
        return $this->render('Front/video/submit.html.twig', [
            'controller_name' => 'VideoController',
        ]);

        $form = $this->createFormBuilder()
        ->add('title', TextType::class, array(
            'constraints' => new NotBlank(),
        ))
        ->add('category', DateType::class, array(
            'constraints' => array(
                new NotBlank(),
                new Type(\DateTime::class),
            )
        ))
        ->getForm();
            }
}
