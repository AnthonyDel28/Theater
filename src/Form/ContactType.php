<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Prénom',
                'attr'  => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('lastName', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Nom',
                'attr'  => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail',
                'attr'  => [
                    'placeholder' => 'E-mail',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('subject', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
                'label' => 'Sujet',
                'attr'  => [
                    'placeholder' => 'Sujet de votre demande',
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr'  => [
                    'placeholder' => 'Message',
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