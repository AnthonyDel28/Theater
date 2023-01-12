<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Migrations\Configuration\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class AdminNewsController extends AbstractController
{
    #[Route('/admin/news', name: 'app_admin_news')]
    public function news(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('admin/news/news.html.twig', [
            'news' => $news
        ]);
    }


    #[Route('/admin/deleteNews/{id}', name: 'app_delete_news')]
    public function delCourse(News $news, EntityManagerInterface $manager) :response {
        $manager->remove($news);
        $manager->flush();
        $this->addFlash(
            'success',
            'Actualité supprimée avec succès!'
        );
        return $this->redirectToRoute('app_admin_news');
    }

}
