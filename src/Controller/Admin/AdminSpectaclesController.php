<?php

namespace App\Controller\Admin;

use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSpectaclesController extends AbstractController
{
    #[Route('/admin/spectacles', name: 'app_admin_spectacles')]
    public function spectacles(SpectaclesRepository $spectaclesRepository): Response
    {
        $spectacles = $spectaclesRepository->findAll();
        return $this->render('admin/spectacles/spectacles.html.twig', [
            'spectacles' => $spectacles,
        ]);
    }
}
