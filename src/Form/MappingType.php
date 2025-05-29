<?php

namespace App\Form;

use App\Entity\Mapping;
use App\Entity\Table;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType as JsonAreaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MappingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['required' => false])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('sourceTable', EntityType::class, [
                'class' => Table::class,
                'choice_label' => 'name'
            ])
            ->add('targetTable', EntityType::class, [
                'class' => Table::class,
                'choice_label' => 'name'
            ])
            ->add('sourceKeyColumn', TextType::class)
            ->add('targetKeyColumn', TextType::class)
            ->add('mappings', JsonAreaType::class, [
                'required' => false,
                'label' => 'Valeurs de mapping (JSON)',
                'attr' => ['rows' => 10, 'class' => 'font-monospace']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mapping::class,
        ]);
    }
}
