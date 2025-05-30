<?php
// src/Form/CaptureElementType.php
namespace App\Capture\Form;

use App\Global\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Capture\Entity\CaptureElement;

class CaptureElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l’objet de capture',
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => 'Description',
            ])
            ->add('respondentRole', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'label' => 'Rôle du répondant',
                'placeholder' => 'Sélectionner un rôle',
            ])
            ->add('validatorRole', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'name',
                'label' => 'Rôle du validateur',
                'placeholder' => 'Sélectionner un rôle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CaptureElement::class,
        ]);
    }
}
