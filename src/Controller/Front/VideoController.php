<?php

namespace App\Controller\Front;

use App\Entity\Video;
use App\Repository\VideoRepository;
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
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * soumettre une nouvelle videoOh sympa 
     * @Route("/video/submit", name="video_submit", methods={"GET", "POST"})
     */
    public function submit (Request $request, VideoRepository $videoRepository, SluggerInterface $slugger): Response
    {
        $videoSubmit = new Video();
        $form = $this->createForm(SubmitType::class, $videoSubmit);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'success', 'Votre bonne pratique a bien été enregistrée. Elle est en attente de modération.'
            );
            $videoSubmit->setSlug($slugger->slug($videoSubmit->getTitle()));
            $videoRepository->add($videoSubmit, true);

            return $this->redirectToRoute(
                'category',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('Front/video/submit.html.twig', [
            "videoSubmit" => $videoSubmit,
            "form" => $form, 
        ]);
    }
}