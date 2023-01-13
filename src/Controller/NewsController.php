<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'app_news')]
    public function news(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findAll();
        $big_header_news = $newsRepository->findBy(['important' => 2], ['createdAt' => 'DESC'], 1);
        $twins_header_news = $newsRepository->findBy(['important' => 1], ['createdAt' => 'DESC'], 2);
        return $this->render('news/index.html.twig', [
            'news' => $news,
            'big_header_news' => $big_header_news,
            'twins_header_news' => $twins_header_news,
        ]);
    }

    #[Route('/news/{slug}', name: 'app_post')]
    public function spectacle(News $news): Response
    {
        return $this->render('news/post.html.twig', [
            'post'  => $news,
        ]);
    }
}
