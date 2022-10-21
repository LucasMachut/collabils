<?php
namespace App\Controller\Front;

use App\Entity\RequestSign;
use App\Entity\Category;
use App\Repository\RequestSignRepository;
use App\Repository\CategoryRepository;
use App\Services\SlugService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\RequestSubmitType;

use Symfony\Component\Routing\Annotation\Route;


class RequestController extends AbstractController
{
    /**
     * @Route("/request/list", name="request_list")
     */
    public function list(RequestSignRepository $requestSignRepository): Response
    {
        $requestedSigns = $requestSignRepository->findAll();

        return $this->render('Front/request/requestList.html.twig', [
            'requestedSigns' => $requestedSigns,
        ]);
    }

    /**
     * soumettre une nouvelle video
     * @Route("/request/submit", name="request_submit", methods={"GET", "POST"})
     *
     **/
    public function submit(Request $request, RequestSignRepository $requestSignRepository, SlugService $slugService): Response
    {
        $requestSignSubmit = new RequestSign();
        $formRequestSignSubmit = $this->createForm(RequestSubmitType::class, $requestSignSubmit);
        $formRequestSignSubmit->handleRequest($request);

        if ($formRequestSignSubmit->isSubmitted() && $formRequestSignSubmit->isValid()) {
            $this->addFlash(
                'success', 'Votre bonne pratique a bien été enregistrée. Elle est en attente de modération.'
            );
            $requestSignSubmit->setSlug($slugService->slug($requestSignSubmit->getTitle()));

            $requestSignRepository->add($requestSignSubmit, true);

            return $this->redirectToRoute(
                'home',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('Front/request/requestSubmit.html.twig', [
            'formRequestSignSubmit' => $formRequestSignSubmit,
            'requestSignSubmit' => $requestSignSubmit,
        ]);

    }
}
