<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\Slider;
use App\Entity\User;
use App\Form\NewSliderFormType;
use App\Form\NewUserFormType;
use App\Repository\NewsRepository;
use App\Repository\SliderRepository;
use Cocur\Slugify\Slugify;
use PhpMyAdmin\Server\Status\Data;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Migrations\Configuration\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NewPostFormType;

class AdminSliderController extends AbstractController
{
    #[Route('/admin/slider', name: 'app_admin_slider')]
    public function slider(SliderRepository $sliderRepository): Response
    {
        $sliders = $sliderRepository->findAll();
        return $this->render('admin/slider/slider.html.twig', [
            'sliders' => $sliders,
        ]);
    }

    #[Route('/admin/new-slider/', name: 'app_admin_new_slider')]
    public function new_slider(EntityManagerInterface $manager, Request $request)
    {
        $slider = new Slider();
        $form = $this->createForm(NewSliderFormType::class, $slider);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $slider->setUpdatedAt(new \DateTimeImmutable());
            $slider->setActive(FALSE);
            $manager->persist($slider);
            $manager->flush();
            $this->addFlash(
                'success',
                'Nouveau slider ajouté avec succès!'
            );
            return $this->redirectToRoute('app_admin_slider');
        }
        return $this->renderForm('admin/slider/new_slider.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/change-active-slider/{id}', name: 'app_change_active_slider')]
    public function change_active_slider(Slider $slider, EntityManagerInterface $manager, SliderRepository
$sliderRepository)
    {
        $active_slider = $sliderRepository->findBy(['active' => 1]);
        foreach($active_slider as $sliders){
            $sliders->setActive(FALSE);
        }
        $slider->setActive(TRUE);
        $manager->persist($slider);
        $manager->flush();
        $this->addFlash(
            'success',
            'Le slider actif a été modifié avec succès!'
        );
        return $this->redirectToRoute('app_admin_slider');
    }

    #[Route('/admin/edit-slider/{id}', name: 'app_edit_slider')]
    public function editSlider(Slider $slider, EntityManagerInterface $manager, Request $request) :response
    {
        $form = $this->createForm(NewSliderFormType::class, $slider);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slider->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($slider);
            $manager->flush();
            $this->addFlash(
                'success',
                'Slider modifié avec succès!'
            );
            return $this->redirectToRoute('app_admin_slider');
        }
        return $this->renderForm('admin/slider/edit_slider.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/deleteSlider/{id}', name: 'app_delete_slider')]
    public function deleteSlider(Slider $slider, EntityManagerInterface $manager) :response {
        $manager->remove($slider);
        $manager->flush();
        $this->addFlash(
            'success',
            'Slider supprimé avec succès!'
        );
        return $this->redirectToRoute('app_admin_slider');
    }
}
