<?php

namespace App\Controller;

use App\Entity\SpectacleComments;
use App\Entity\Spectacles;
use App\Repository\ActorsRepository;
use App\Repository\SpectacleCommentsRepository;
use App\Repository\SpectaclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CommentFormType;

class SpectaclesController extends AbstractController
{
    #[Route('/spectacles', name: 'app_spectacles')]
    public function spectacles(SpectaclesRepository $spectaclesRepository)
    : Response
    {
        $shows = $spectaclesRepository->findAll();
        return $this->render('spectacles/spectacles.html.twig', [
            'spectacles' => $shows,
        ]);
    }

    #[Route('/spectacle/{slug}', name: 'spectacle')]
    public function post(Spectacles $spectacles, EntityManagerInterface $manager, \Symfony\Component\HttpFoundation\Request
                              $request, SpectacleCommentsRepository $spectacleCommentsRepository): Response
    {
        $comment = new SpectacleComments();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        $spectacleId = $spectacles->getId();
        $comments = $spectacleCommentsRepository->findBy(['spectacle' => $spectacleId]);
        $route_slug = $spectacles->getSlug();
        $spectacle = $manager->getRepository(Spectacles::class)->find($spectacleId);
        if($this->getUser()){
            $user = $manager->getRepository(Spectacles::class)->find($this->getUser());
        }
        if($form->isSubmitted() && $form->isValid()){
            $comment->setUser($this->getUser());
            $comment->setSpectacle($spectacle);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash(
                'success',
                'Commentaire ajouté avec succès!'
            );
            return $this->redirect("/spectacle/". $route_slug);
        }
        return $this->renderForm('spectacles/spectacle.html.twig', [
            'spectacle' => $spectacle,
            'post'  => $spectacle,
            'form' => $form,
            'comments' => $comments,
        ]);
    }
}
