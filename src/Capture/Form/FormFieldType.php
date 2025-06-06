<?php
// src/Capture/Form/FormFieldType.php

namespace App\Capture\Form;

use App\Capture\Entity\FormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Libellé du champ',
                ]
            ])
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => 'Nom technique (utilisé pour le rendu)'
                ]
            ])
            ->add('type', HiddenType::class)
            ->add('position', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormField::class,
        ]);
    }
}
