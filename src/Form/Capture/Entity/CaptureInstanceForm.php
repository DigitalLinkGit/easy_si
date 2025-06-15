<?php

namespace App\Form\Capture\Entity;

use App\Capture\Entity\Capture;
use App\Capture\Entity\CaptureInstance;
use App\Global\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaptureInstanceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('capture', EntityType::class, [
                'class' => Capture::class,
                'choice_label' => 'id',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CaptureInstance::class,
        ]);
    }
}
