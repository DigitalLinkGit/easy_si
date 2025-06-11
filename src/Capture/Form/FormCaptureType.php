<?php
// src/Capture/Form/FormCaptureType.php

namespace App\Capture\Form;

use App\Capture\Entity\FormCapture;
use App\Global\Entity\Role;
use App\Capture\Form\FormFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCaptureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du formulaire',
            ])
            ->add('respondentRole', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'label' => 'Rôle du répondant',
                'placeholder' => 'Sélectionner un rôle',
            ])
            ->add('validatorRole', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'label' => 'Rôle du validateur',
                'placeholder' => 'Sélectionner un rôle',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('fields', CollectionType::class, [
                'entry_type' => FormFieldType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Champs du formulaire',
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => ['label' => false],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormCapture::class,
        ]);
    }
}
