<?php
namespace App\Capture\Form;

use App\Capture\Entity\QuizCapture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreviewType extends AbstractType
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
                'required' => false,
                'choices' => [
                    'Titre 1' => 1,
                    'Titre 2' => 2,
                    'Titre 3' => 3,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizCapture::class,
        ]);
    }
}
