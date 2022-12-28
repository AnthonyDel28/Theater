<?php

namespace App\Controller;

use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpectaclesController extends AbstractController
{
    #[Route('/spectacles', name: 'app_spectacles')]
    public function spectacles(SpectaclesRepository $spectaclesRepository): Response
    {
        $spectacles = $spectaclesRepository->findAll();
        return $this->render('spectacles/spectacles.html.twig', [
            'spectacles' => $spectacles
        ]);
    }
}
