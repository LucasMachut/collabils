<?php

namespace App\Controller\Front;

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\NewUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Services\SlugService;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('Front/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    //* Route to add a new user

    /**
     * @Route ("/user/new", name="user_new", methods={"GET","POST"})
     * @param int $id
    */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(NewUserType::class, $user);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre compte a été créé ! Vous pouvez dès à présent vous connecter.');
            $plaintextPassword= $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setStatus(1);
            $user->setRoles(['ROLE_USER']);
            $user->setSlug($slug->slug($user->getFirstname()));
            $userRepository->add($user, true);

            return $this->redirectToRoute('security_login', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('Front/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
