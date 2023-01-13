<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController {

    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function home(NewsRepository $newsRepository, SpectaclesRepository $spectaclesRepository) :Response {
        $news = $newsRepository->findBy([], ['createdAt' => 'DESC'], 4);
        $spectacles = $spectaclesRepository->findAll();

        return $this->render('home/index.html.twig', [

            'news' => $news,
            'spectacles' => $spectacles,
        ]);
    }
}