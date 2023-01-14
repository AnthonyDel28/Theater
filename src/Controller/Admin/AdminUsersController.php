<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\NewUserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUsersController extends AbstractController
{
    #[Route('/admin/users', name: 'app_admin_users')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/newuser', name: 'app_admin_new_user')]
    public function newUser(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $form = $this->createForm(NewUserFormType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $slug = new Slugify();
            $user   ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setSlug($slug->slugify($user->getfirstName() . ' ' . $user->getLastName()));
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);
            $user->setActive(TRUE);
            $user->setImageName('default.jpg');
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Nouvel utilisateur créé avec succès!'
            );
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->renderForm('admin/users/newuser.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/user/{id}', name: 'app_admin_delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $manager) :response {
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'Le membre ' . $user->getfirstName() . ' ' . $user->getLastName() . ' a bien été supprimé'
        );
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/admin/edit-user/{id}', name: 'app_admin_edit_user')]
    public function editUser(User $user, EntityManagerInterface $manager, Request $request)
    {
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slugify = new Slugify();
            $user->setSlug($slugify->slugify($user->getFirstName() . ' ' . $user->getLastName()));
            $user->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Utilisateur modifiée avec succès!'
            );
            return $this->redirectToRoute('app_admin_users');
        }
        return $this->renderForm('admin/users/edit_user.html.twig', [
            'form' => $form
        ]);
    }
}
