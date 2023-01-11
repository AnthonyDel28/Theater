<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminNewsController extends AbstractController
{
    #[Route('/admin/news', name: 'app_admin_news')]
    public function index(): Response
    {
        return $this->render('admin_news/index.html.twig', [
            'controller_name' => 'AdminNewsController',
        ]);
    }
}
