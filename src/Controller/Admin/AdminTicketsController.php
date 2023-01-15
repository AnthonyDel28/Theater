<?php

namespace App\Controller\Admin;

use App\Entity\Spectacles;
use App\Form\EditShowFormType;
use App\Repository\SpectaclesRepository;
use App\Repository\TicketsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;

class AdminTicketsController extends AbstractController
{
    #[Route('/admin/tickets', name: 'app_admin_tickets')]
    public function spectacles(TicketsRepository $ticketsRepository): Response
    {
        $tickets = $ticketsRepository->findAll();
        return $this->render('admin/tickets/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }

}
