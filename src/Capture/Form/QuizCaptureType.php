<?php

namespace App\Capture\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Capture\Entity\QuizCapture;

class QuizCaptureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuizCapture::class,
        ]);
    }

    public function getParent(): string
    {
        return CaptureElementType::class;
    }
}
