<?php

namespace App\Controller;

use App\Entity\Spectacles;
use App\Repository\ActorsRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SpectaclesController extends AbstractController
{
    #[Route('/spectacles', name: 'app_spectacles')]
    public function spectacles(SpectaclesRepository $spectaclesRepository)
    : Response
    {
        $shows = $spectaclesRepository->findAll();
        return $this->render('spectacles/spectacles.html.twig', [
            'spectacles' => $shows,
        ]);
    }

    #[Route('/spectacle/{slug}', name: 'spectacle')]
    public function spectacle(Spectacles $spectacles): Response
    {
        return $this->render('spectacles/spectacle.html.twig', [
            'spectacle'  => $spectacles,
        ]);
    }

}
