<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterFormType;
use App\Repository\NewsRepository;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController {

    #[Route('/', name: 'home')]
    public function home(NewsRepository $newsRepository, SpectaclesRepository $spectaclesRepository,
                         EntityManagerInterface $manager)
    :Response
    {
        $news = $newsRepository->findBy([], ['createdAt' => 'DESC'], 4);
        $spectacles = $spectaclesRepository->findAll();

        return $this->renderForm('home/index.html.twig', [
            'news' => $news,
            'spectacles' => $spectacles,
        ]);
    }

}