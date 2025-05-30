<?php

namespace App\Design\Form;

use App\Design\Entity\Element;
use App\Design\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type de service',
                'choices' => [
            'API OData' => 'odata',
            'API REST' => 'rest',
            'API SOAP' => 'soap',
            'Fichiers' => 'file',
            'Autre transport de données' => 'other',
        ],
                'placeholder' => 'Choisir un type de service',
            ])
            ->add('name')
            ->add('description')
            ->add('endpoint')
            ->add('authMethod')
            ->add('method')
            ->add('format')
            ->add('direction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
