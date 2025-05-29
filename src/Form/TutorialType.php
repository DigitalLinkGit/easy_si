<?php

namespace App\Form;

use App\Entity\Tutorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TutorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 3],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('route', ChoiceType::class, [
                'label' => 'Route ciblée',
                'choices' => $options['routes'],
                'placeholder' => 'Sélectionnez une route...',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('steps', CollectionType::class, [
                'entry_type' => TutorialStepType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => false,
                'attr' => ['data-controller' => 'collection'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
         $resolver->setDefaults([
        'data_class' => Tutorial::class,
        'routes' => [],
    ]);
    }
}
