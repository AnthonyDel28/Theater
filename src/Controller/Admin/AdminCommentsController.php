<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Entity\SpectacleComments;
use App\Repository\CommentsRepository;
use App\Repository\SpectacleCommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminCommentsController extends AbstractController
{
    #[Route('/admin/comments', name: 'app_admin_comments')]
    public function comments(CommentsRepository $commentsRepository, SpectacleCommentsRepository $spectacleCommentsRepository): Response
    {
        $comments = $commentsRepository->findAll();
        $spectacle_comments = $spectacleCommentsRepository->findAll();
        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
            'spectacle_comments' =>$spectacle_comments,
        ]);
    }

    #[Route('/admin/deleteComment/{id}', name: 'app_delete_comment')]
    public function delComment(Comments $comments, EntityManagerInterface $manager) :response {
        $manager->remove($comments);
        $manager->flush();
        $this->addFlash(
            'success',
            'Commentaire supprimé avec succès!'
        );
        return $this->redirectToRoute('app_admin_comments');
    }

    #[Route('/admin/deleteSpectacleComment/{id}', name: 'app_delete_spectacle_comment')]
    public function delSpectacleComment(SpectacleComments $spectacleComments, EntityManagerInterface $manager) :response {
        $manager->remove($spectacleComments);
        $manager->flush();
        $this->addFlash(
            'success',
            'Commentaire supprimé avec succès!'
        );
        return $this->redirectToRoute('app_admin_comments');
    }
}
