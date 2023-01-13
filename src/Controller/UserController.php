<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use App\Form\EditProfilePictureType;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);
        $profile_picture_form = $this->createForm(EditProfilePictureType::class, $user);
        $profile_picture_form->handleRequest($request);
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
        ]);
    }

}
