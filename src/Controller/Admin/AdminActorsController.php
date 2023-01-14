<?php

namespace App\Controller\Admin;

use App\Entity\Actors;
use App\Form\ActorFormType;
use App\Form\NewActorFormType;
use App\Repository\ActorsRepository;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;

class AdminActorsController extends AbstractController
{
    #[Route('/admin/comedians', name: 'app_admin_actors')]
    public function actors(ActorsRepository $actorsRepository, SpectaclesRepository $spectaclesRepository): Response
    {
        $comedians = $actorsRepository->findAll();
        $spectacles = $spectaclesRepository->findAll();
        return $this->render('admin/actors/actors.html.twig', [
            'actors' => $comedians,
            'spectacles' => $spectacles,
        ]);
    }


    #[Route('/admin/editactor/{id}', name: 'app_admin_edit_actor')]
    public function editActor(Actors $actors, EntityManagerInterface $manager, Request $request) :Response
    {
        $form = $this->createForm(ActorFormType::class, $actors);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $actors->setSlug($slugify->slugify($actors->getFirstName() . ' ' . $actors->getFirstName()));
            $actors->setActive(TRUE);
            $manager->persist($actors);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le comédien ' . $actors->getFirstName() . ' ' . $actors->getLastName() . ' a été modifié avec succès!'
            );
            return $this->redirectToRoute('app_admin_actors');
        }
        return $this->renderForm('admin/actors/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/newactor/', name: 'app_admin_new_actor')]
    public function newActor(EntityManagerInterface $manager, Request $request) :Response
    {
        $actor = new Actors();
        $form = $this->createForm(NewActorFormType::class, $actor);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $actor->setSlug($slugify->slugify($actor->getFirstName() . ' ' . $actor->getFirstName()));
            $actor->setActive(TRUE);
            $manager->persist($actor);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le comédien ' . $actor->getFirstName() . ' ' . $actor->getLastName() . ' a été ajouté avec succès!'
            );
            return $this->redirectToRoute('app_admin_actors');
        }
        return $this->renderForm('admin/actors/newactor.html.twig', [
            'form' => $form
        ]);
    }
}
