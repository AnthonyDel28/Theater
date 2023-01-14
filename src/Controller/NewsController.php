<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\News;
use App\Form\CommentFormType;
use App\Repository\CommentsRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
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
    public function post(News $news, EntityManagerInterface $manager, \Symfony\Component\HttpFoundation\Request
    $request, CommentsRepository $commentsRepository): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        $postId = $news->getId();
        $comments = $commentsRepository->findBy(['news' => $postId]);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setUser($this->getUser());
            $comment->setNews($news);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();
            return $this->redirect($request->getUri());
        }
        return $this->renderForm('news/post.html.twig', [
            'post'  => $news,
            'form' => $form,
            'comments' => $comments,
        ]);
    }
}
