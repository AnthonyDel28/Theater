<?php

namespace App\Controller\Admin;

use App\Entity\Actors;
use App\Repository\ActorsRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminActorsController extends AbstractController
{
    #[Route('/admin/comedians', name: 'app_admin_actors')]
    public function actors(ActorsRepository $actorsRepository, SpectaclesRepository $spectaclesRepository): Response
    {
        $comedians = $actorsRepository->findAll();
        $spectacles = $spectaclesRepository->findAll();
        return $this->render('admin/actors/actors.html.twig', [
            'actors' => $comedians,
            'spectacles' => $spectacles,
        ]);
    }
}
