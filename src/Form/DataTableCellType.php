<?php
// src/Form/TableCellType.php

namespace App\Form;

use App\Entity\DataTableCell;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataTableCellType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rowIndex', TextType::class, ['label' => 'Ligne'])
            ->add('colIndex', TextType::class, ['label' => 'Colonne'])
            ->add('columnName', TextType::class, ['label' => 'Nom de colonne'])
            ->add('value', TextType::class, ['label' => 'Valeur']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DataTableCell::class,
        ]);
    }
}
