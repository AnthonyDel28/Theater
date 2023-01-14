<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditShowFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr'  => [
                    'placeholder' => 'Titre du spectacle',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('period', TextType::class, [
                'label' => 'Période',
                'attr'  => [
                    'placeholder' => 'Période',
                    'class' => 'form-control mb-5',
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur',
                'attr'  => [
                    'placeholder' => 'Nom de l\'auteur',
                    'class' => 'form-control mb-5',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Résumé',
                'attr'  => [
                    'placeholder' => 'Résumé',
                    'class' => 'form-control mb-5',
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image du spectacle',
                'required'  => false,
                'image_uri' => false ,
                'download_label' => false,
                'allow_delete' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }
}