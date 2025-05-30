<?php

namespace App\Test\Form;

use App\Test\Entity\TutorialStep;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TutorialStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('number',NumberType::class, [
            'label' => 'étape',
        ])
        ->add('content',TextareaType::class, [
            'label' => 'Message',
        ])
        ->add('domElement',TextareaType::class, [
            'label' => 'Elément du DOM cible',
            //'placeholder' => 'ex: #navbarMain, .btn-add, etc.',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TutorialStep::class,
        ]);
    }
}
