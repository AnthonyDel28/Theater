<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('login_message', name: 'app_login_redirect')]
    public function loginMessage(SessionInterface $session){
        if($session->get('not_logged') == TRUE){
            return $this->redirectToRoute('app_cart');
        }
        $this->addFlash('success', "Vous êtes maintenant connecté!");
        return $this->redirectToRoute('home');
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {

    }
}