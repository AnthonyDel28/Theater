<?php

namespace App\Controller;


use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Cocur\Slugify\Slugify;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $slugify = new Slugify();
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $newsletter = new Newsletter();
        if ($form->isSubmitted() && $form->isValid()) {
            $user   ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $newsletter->setEmail($user->getEmail());
            $user   ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setRoles(['ROLE_USER'])
                ->setActive(TRUE)
                ->setImageName('default.jpg')
                ->setSlug($slugify->slugify($user->getFirstName() . ' ' . $user->getLastName()));
            $entityManager->persist($user);
            $entityManager->persist($newsletter);
            $entityManager->flush();



            $this->addFlash(
                'success_registration',
                'Inscription terminée avec succès, vous pouvez vous connecter!'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}