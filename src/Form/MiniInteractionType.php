<?php

namespace App\Form;

use App\Entity\Interaction;
use App\Entity\Element;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MiniInteractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, [
                'required' => true,
            ])
            ->add('dataName', TextType::class, [
                'required' => true,
                'label' => 'Nom de la donnée',
                'mapped' => true,
            ])
            ->add('elementIn', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'name',
                'label' => 'Entré',
            ])
            ->add('elementOut', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'name',
                'label' => 'Sortie',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => ['rows' => 2],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interaction::class,
        ]);
    }
}
