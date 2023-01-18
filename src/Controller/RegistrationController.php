<?php

namespace App\Controller;


use App\Entity\Newsletter;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Cocur\Slugify\Slugify;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager, MailerInterface $mailer): Response
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
            $email = new TemplatedEmail();
            $email->from('contact@petittheatredelaruelle.be')
                ->to($user->getEmail())
                ->subject('Le Petit Théâtre vous souhaite la bienvenue!')
                ->text('Sending emails is fun again!')
                ->htmlTemplate('contact/registration.html.twig')
                ->context(
                    [
                        'firstName' => $user->getFirstName(),
                        'lastName' => $user->getLastName(),
                        'user_email' => $user->getEmail(),
                    ]
                );

            $mailer->send($email);
            $this->addFlash(
                'success_registration',
                'Inscription terminée avec succès, un mail de confirmation vous a été envoyé! Vous pouvez vous connecter!'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}