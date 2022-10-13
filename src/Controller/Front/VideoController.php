<?php

namespace App\Controller\Front;

use App\Entity\Video;
use App\Entity\Category;
use App\Repository\VideoRepository;
use App\Services\SlugService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\VideoSubmitType;
use Symfony\Component\String\Slugger\SluggerInterface;

class VideoController extends AbstractController
{
    /**
     * @Route("Front/video/home", name="video_home")
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
     *
     **/
    public function submit(Request $request, VideoRepository $videoRepository, SlugService $slugService): Response
    {
        $videoSubmit = new Video();
        $form = $this->createForm(VideoSubmitType::class, $videoSubmit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'success', 'Votre bonne pratique a bien été enregistrée. Elle est en attente de modération.'
            );
            $videoSubmit->setSlug($slugService->slug($videoSubmit->getTitle()));

            $videoRepository->add($videoSubmit, true);

            return $this->redirectToRoute(
                'category_show_practice',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('Front/video/submit.html.twig', [
            'videoSubmit' => $videoSubmit,
            'form' => $form,
        ]);
    }


        /**
     * @Route("/video/submit", name="video_submit", methods={"GET", "POST"})
     *
     * @return Response

    public function submit (
        Video $video,
        Request $request,
        ManagerRegistry $doctrine,
        SluggerInterface $slugger
    ): Response
    {
        // Grphp bin/console debug:router
        $form = $this->createForm(ReviewType::class, $video);

        //récupération de la réponse
        $form->handleRequest($request);

        // Si le formulaire a été soumis et que les données sont valides...
        if($form->isSubmitted() && $form->isValid()) {
            $video->setSlug($slugger->slug($video->getTitle()));
            $em = $doctrine->getManager();
            $em->persist($video);
            $em->flush();

            // redirection vers la page movieShow
            return $this->redirectToRoute('category');
        }

        //? utilisation de renderForm à la place render()
        //https://symfony.com/doc/5.4/forms.html#rendering-forms
        return $this->renderForm('Front/video/submit.html.twig', [
            "video" => $video,
            "form" => $form,
        ]);
    }
**/
}