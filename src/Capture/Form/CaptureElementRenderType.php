<?php

namespace App\Capture\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Capture\Entity\CaptureElement;

class CaptureElementRenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('renderTitle', TextType::class, [
                'label' => 'Titre du chapitre',
                'required' => false,
            ])
            ->add('renderTitleLevel', ChoiceType::class, [
                'label' => 'Niveau de titre',
                'choices' => [
                    'Titre 1' => 1,
                    'Titre 2' => 2,
                    'Titre 3' => 3,
                ],
                'required' => false,
            ])
            ->add('renderTemplate', TextareaType::class, [
                'label' => 'Contenu du rendu (avec variables)',
                'required' => false,
                'attr' => [
                    'rows' => 20,
                    'style' => 'font-family:monospace; white-space:pre-wrap;',
                ],
            ])
            ->add('results', CollectionType::class, [
                'entry_type' => RenderResultType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options'=>['label'=>false],
                'attr'=>['data-controller'=>'form-collection']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CaptureElement::class,
        ]);
    }
}
