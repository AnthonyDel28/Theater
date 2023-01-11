<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUsersController extends AbstractController
{
    #[Route('/admin/users', name: 'app_admin_users')]
    public function index(): Response
    {
        return $this->render('admin_users/index.html.twig', [
            'controller_name' => 'AdminUsersController',
        ]);
    }
}
