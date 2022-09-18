<?php

namespace App\Controller\Front;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
    public function submit (Request $request, ManagerRegistry $doctrine): Response
    {
        $submitVideo = new Video();

        $form = $this->createFormBuilder($submitVideo)
        ->add('Title', TextType::class, array(
            'constraints' => new NotBlank(),
        ))
        ->add('Definition', TextType::class, array(
            'constraints' => new NotBlank(),
        ))
        ->add('Context', TextType::class, array(
            'constraints' => new NotBlank(),
        ))
        ->add('Category', ChoiceType::class, [
                'choices'  => [
                    'Physique' => 'physics',
                    'Psychologie' => 'psychology',
                    'Informatique' => 'computer_science',
                ],
            ]   
        )

        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On va faire appel au Manager de Doctrine
            $entityManager = $doctrine->getManager();
            $entityManager->persist($submitVideo);
            $entityManager->flush();

            // On redirige vers la liste
            return $this->redirectToRoute('video_home');
        }

        
        return $this->render('Front/video/submit.html.twig', [
            'controller_name' => 'VideoController',
            'formSubmit' => $form->createView()
        ]);
    }
}