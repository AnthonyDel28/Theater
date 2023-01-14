<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Like;
use App\Entity\News;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Repository\CommentsRepository;
use App\Repository\LikeRepository;
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
    $request, CommentsRepository $commentsRepository, LikeRepository $likeRepository): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        $postId = $news->getId();
        $comments = $commentsRepository->findBy(['news' => $postId]);
        $likes = $likeRepository->findBy(['news' => $postId]);
        $likes_count = count($likes);
        $route_slug = $news->getSlug();
        $post = $manager->getRepository(News::class)->find($postId);
        if($this->getUser()){
            $user = $manager->getRepository(User::class)->find($this->getUser());
            $is_liked = $likeRepository->findOneBy(['news' => $post, 'user' => $user]);
        } else {
            $is_liked = null;
        }
        if($form->isSubmitted() && $form->isValid()){
            $comment->setUser($this->getUser());
            $comment->setNews($news);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                'Commentaire ajouté avec succès!'
            );
            return $this->redirect("/news/". $route_slug . "/#comment-anchor");
        }
        return $this->renderForm('news/post.html.twig', [
            'post'  => $news,
            'form' => $form,
            'comments' => $comments,
            'likes' => $likes_count,
            'is_liked' => $is_liked
        ]);
    }


    #[Route('/news/like/{id}', name: 'app_like')]
    public function likePost( EntityManagerInterface $manager,\Symfony\Component\HttpFoundation\Request
    $request, LikeRepository $likeRepository, int $id, NewsRepository $newsRepository) :Response
    {
        $route = $request->headers->get('referer');
        $post = $manager->getRepository(News::class)->find($id);
        $user = $manager->getRepository(User::class)->find($this->getUser());
        $currentPost = $newsRepository->findOneBy(['id' => $post]);
        $is_liked = $likeRepository->findOneBy(['news' => $post, 'user' => $user]);
        $route_slug = $currentPost->getSlug();
        if(!$is_liked){
            $like = new Like();
            $like->setUser($user);
            $like->setNews($post);
            $manager->persist($like);
        } else {
            $manager->remove($is_liked);
        }
        $manager->flush();
        return $this->redirect("/news/". $route_slug . "/#like-section");
    }
}
