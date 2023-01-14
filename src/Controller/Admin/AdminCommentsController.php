<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AdminCommentsController extends AbstractController
{
    #[Route('/admin/comments', name: 'app_admin_comments')]
    public function comments(CommentsRepository $commentsRepository): Response
    {
        $comments = $commentsRepository->findAll();
        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/admin/deleteComment/{id}', name: 'app_delete_comment')]
    public function delCourse(Comments $comments, EntityManagerInterface $manager) :response {
        $manager->remove($comments);
        $manager->flush();
        $this->addFlash(
            'success',
            'Commentaire supprimé avec succès!'
        );
        return $this->redirectToRoute('app_admin_comments');
    }
}
