<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\User;
use App\Form\NewUserFormType;
use App\Repository\NewsRepository;
use Cocur\Slugify\Slugify;
use PhpMyAdmin\Server\Status\Data;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Migrations\Configuration\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NewPostFormType;

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

    #[Route('/admin/newpost', name: 'app_admin_new_post')]
    public function newPost(EntityManagerInterface $manager, Request $request)
    {
        $post = new News();
        $form = $this->createForm(NewPostFormType::class, $post);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid()){
            $slugify = new Slugify();
            $post->setAuthor($user)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setIsPublished(TRUE)
                ->setSlug($slugify->slugify($post->getTitle()))
                ->setImageName('test.jpg')
                ->setImportant(0);
            $manager->persist($post);
            $manager->flush();
            $this->addFlash(
                'success',
                'Nouvelle actualité publiée avec succès!'
            );
            return $this->redirectToRoute('app_admin_news');
        }
        return $this->renderForm('admin/news/new_post.html.twig', [
            'form' => $form
            ]);
    }

    #[Route('/admin/editpost/{id}', name: 'app_admin_edit_post')]
    public function editPost(EntityManagerInterface $manager, Request $request, News $post)
    {
        $form = $this->createForm(NewPostFormType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slugify = new Slugify();
            $post
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setSlug($slugify->slugify($post->getTitle()));
            $manager->persist($post);
            $manager->flush();
            $this->addFlash(
                'success',
                'Actualité modifiée avec succès!'
            );
            return $this->redirectToRoute('app_admin_news');
        }
        return $this->renderForm('admin/news/edit_post.html.twig', [
            'form' => $form
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
