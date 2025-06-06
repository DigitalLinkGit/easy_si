<?php
// src/Capture/Form/FormCaptureType.php

namespace App\Capture\Form;

use App\Capture\Entity\FormCapture;
use App\Capture\Form\FormFieldType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
