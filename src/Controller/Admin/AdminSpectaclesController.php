<?php

namespace App\Controller\Admin;

use App\Entity\Spectacles;
use App\Form\EditShowFormType;
use App\Repository\SpectaclesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Cocur\Slugify\Slugify;

class AdminSpectaclesController extends AbstractController
{
    #[Route('/admin/spectacles', name: 'app_admin_spectacles')]
    public function spectacles(SpectaclesRepository $spectaclesRepository): Response
    {
        $spectacles = $spectaclesRepository->findAll();
        return $this->render('admin/spectacles/spectacles.html.twig', [
            'spectacles' => $spectacles,
        ]);
    }

    #[Route('/admin/editshow/{id}', name: 'app_admin_edit_spectacle')]
    public function editShow(EntityManagerInterface $manager, \Symfony\Component\HttpFoundation\Request $request , Spectacles
    $show)
    {
        $form = $this->createForm(EditShowFormType::class, $show);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slugify = new Slugify();
            $show
                ->setSlug($slugify->slugify($show->getTitre()))
                ->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($show);
            $manager->flush();
            $this->addFlash(
                'success',
                'Spectacle modifiée avec succès!'
            );
            return $this->redirectToRoute('app_admin_spectacles');
        }
        return $this->renderForm('admin/spectacles/edit_show.html.twig', [
            'form' => $form
        ]);
    }
}
