<?php

namespace App\Capture\Form;

use App\Capture\Entity\RenderResult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RenderResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom de la variable',
                    'class' => 'form-control',
                ]
            ])
            ->add('expression', TextType::class, [
                'required' => true,
                'label' => false,
                'row_attr' => [
                    'class' => 'flex-grow-1',
                ],
                'attr' => [
                    'placeholder' => 'Expression (ex: [a] * 1.2)',
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RenderResult::class,
        ]);
    }
}
