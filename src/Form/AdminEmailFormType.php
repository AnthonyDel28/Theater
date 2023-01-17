<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminEmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Destinataire',
                'attr'  => [
                    'placeholder' => 'Adresse mail',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('subject', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Sujet',
                'attr'  => [
                    'placeholder' => 'Sujet',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('message', CKEditorType::class, [
                'label' => 'Votre message',
                'attr'  => [
                    'placeholder' => 'Contenu',
                    'class' => 'form-control mb-3',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}