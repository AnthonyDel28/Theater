<?php

namespace App\Controller\Admin;

use App\Repository\ActorsRepository;
use App\Repository\CommentsRepository;
use App\Repository\NewsRepository;
use App\Repository\SpectaclesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function home(UserRepository $userRepository, NewsRepository $newsRepository, SpectaclesRepository $spectaclesRepository,
    CommentsRepository $commentsRepository, ActorsRepository $actorsRepository): Response
    {
        $actors = $actorsRepository->findAll();
        $news = $newsRepository->findAll();
        $users = $userRepository->findAll();
        $spectacles = $spectaclesRepository->findAll();
        $comments = $commentsRepository->findAll();
        $admins = $userRepository->findByRole('ROLE_SUPER_ADMIN');
        return $this->render('admin/index.html.twig', [
            'actors' => count($actors),
            'news' => count($news),
            'users' => count($users),
            'spectacles' => count($spectacles),
            'comments' => count($comments),
            'admins_count' => count($admins),
            'admins' => $admins,
        ]);
    }
}
