<?php

namespace App\Controller;

use App\Form\EditProfilePictureType;
use App\Form\EditProfileType;
use App\Repository\CommentsRepository;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $manager,
                            CommentsRepository $commentsRepository, TicketsRepository $ticketsRepository):
    Response
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);
        $comments = $commentsRepository->findBy(['user' => $user_id]);
        $profile_picture_form = $this->createForm(EditProfilePictureType::class, $user);
        $profile_picture_form->handleRequest($request);
        $tickets = $ticketsRepository->findBy(['user' => $user_id]);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable());
            $manager->flush();
            $this->addFlash('success', "Profil modifié avec succès!");
            return $this->redirectToRoute('app_profile');
        }
        if($profile_picture_form->isSubmitted() && $profile_picture_form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable());
            $manager->flush();
            $this->addFlash('success', "Photo de profil modifiée avec succès!");
            if($user->getImageName() == null){
                $user->setImageName('default.jpg');
            }
            return $this->redirectToRoute('app_profile');
        }
        return $this->renderForm('user/profile.html.twig', [
            'form' => $form,
            'profile_picture_form' => $profile_picture_form,
            'comments' => $comments,
            'tickets' => $tickets,
        ]);
    }

}
