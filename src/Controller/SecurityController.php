<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/logout_message', name: 'app_logout_redirect')]
    public function logoutMessage(){
        $this->addFlash('success', "Vous êtes maintenant déconnecté, au revoir!");
        return $this->redirectToRoute('home');
    }

}