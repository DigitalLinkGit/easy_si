<?php

namespace App\Capture\Form;

use App\Capture\Entity\FormCapture;
use App\Capture\Enum\AnswerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCaptureResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var FormCapture $formCapture */
        $formCapture = $options['element'];

        foreach ($formCapture->getFields() as $field) {
            $name = $field->getName();
            $label = $field->getLabel() ?? $name;
            $type = $field->getType();

            if (!$type instanceof AnswerType) {
                continue;
            }


            switch ($type) {
                case AnswerType::TEXT:
                    $builder->add($name, TextareaType::class, ['label' => $label, 'required' => false]);
                    break;
                case AnswerType::NUMBER:
                    $builder->add($name, NumberType::class, ['label' => $label, 'required' => false]);
                    break;
                case AnswerType::DATE:
                    $builder->add($name, DateType::class, ['label' => $label, 'widget' => 'single_text', 'required' => false]);
                    break;
                case AnswerType::BOOLEAN:
                    $builder->add($name, CheckboxType::class, ['label' => $label, 'required' => false]);
                    break;
                case AnswerType::SINGLE_CHOICE:
                    $builder->add($name, ChoiceType::class, [
                        'label' => $label,
                        'choices' => $field->getOptions() ?? [],
                        'expanded' => true,
                        'multiple' => false,
                        'required' => false,
                    ]);
                    break;
                case AnswerType::MULTI_CHOICE:
                    $builder->add($name, ChoiceType::class, [
                        'label' => $label,
                        'choices' => $field->getOptions() ?? [],
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false,
                    ]);
                    break;
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'element' => null,
        ]);
    }
}
