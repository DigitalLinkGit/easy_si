<?php
// src/Form/DataRequestType.php

namespace App\Design\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', ChoiceType::class, [
                'choices' => [
                    'OData' => 'odata',
                    'SOAP'  => 'soap',
                    'REST'  => 'rest',
                    'Fichier' => 'file',
                ],
                'mapped' => false,
                'data'   => $options['data']['source'] ?? 'odata',
            ])
            ->add('url', TextType::class, [
                'required' => true,
                'label'    => 'URL ou chemin de la source',
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'label'    => 'Utilisateur (si nécessaire)',
            ])
             ->add('password', PasswordType::class, [
        'required' => false,
        'label' => 'Mot de passe (si nécessaire)',
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => ['source' => 'odata'],
        ]);
    }
}
