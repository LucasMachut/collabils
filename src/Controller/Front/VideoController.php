<?php

namespace App\Controller\Front;

use App\Entity\Video;
use App\Entity\Category;
use App\Repository\VideoRepository;
use App\Repository\CategoryRepository;
use App\Services\SlugService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\VideoSubmitType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
     * soumettre une nouvelle video
     * @Route("/video/submit", name="video_submit", methods={"GET", "POST"})
     *
     **/
    public function submit(Request $request, VideoRepository $videoRepository, SlugService $slugService): Response
    {
        $videoSubmit = new Video();
        $formVideoSubmit = $this->createForm(VideoSubmitType::class, $videoSubmit);
        $formVideoSubmit->handleRequest($request);

        if ($formVideoSubmit->isSubmitted() && $formVideoSubmit->isValid()) {
            $this->addFlash(
                'success', 'Votre bonne pratique a bien été enregistrée. Elle est en attente de modération.'
            );
            $videoSubmit->setSlug($slugService->slug($videoSubmit->getTitle()));

            $videoRepository->add($videoSubmit, true);

            return $this->redirectToRoute(
                'home',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('Front/video/submit.html.twig', [
            'formVideoSubmit' => $formVideoSubmit,
            'videoSubmit' => $videoSubmit,
        ]);
    }

    /**
     * @Route("/video/chrono", name="video_list_chrono")
     */
    public function list(VideoRepository $videoRepository): Response
    {
        $videos = $videoRepository->findAll();

        return $this->render('Front/video/videoChrono.html.twig', [
            'videos' => $videos,
        ]);
    }

    /**
     * @Route(
     *      "/video/{slug}", 
     *      name="video_item", 
     *      methods={"GET"}, 
     *      requirements={"slug"="[\w-]+"})
     * 
     * @param string $slug 
     * @return Response
     */
    public function showItem(string $slug, VideoRepository $videoRepository): Response
    {
        $dataVideo = $videoRepository->findOneBy(['slug' => $slug]);

        // Si l'id contient un index qui n'existe pas
        if (is_null($dataVideo)) {
            throw $this->createNotFoundException('Le film n\'existe pas.');
        }

        // on renvoie le template twig dans lequel on transmet les données du film demandé en paramètre
        return $this->render(
            'front/main/video-show.html.twig',
            [
                'video' => $dataVideo
            ]
        );
    }

}