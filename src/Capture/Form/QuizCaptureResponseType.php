<?php

namespace App\Capture\Form;

use App\Capture\Entity\QuizCapture;
use App\Capture\Enum\AnswerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class QuizCaptureResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var QuizCapture $quiz */
        $quiz = $options['element'];

        foreach ($quiz->getQuestions() as $question) {
            $label = $question->getContent();
            $type = $question->getType();


            if (!$type instanceof AnswerType) {
                continue;
            }

            $fieldName = 'question_' . $question->getId();

            switch ($type) {
                case AnswerType::TEXT:
                    $builder->add($fieldName, TextareaType::class, [
                        'label' => $label,
                        'required' => false,
                    ]);
                    break;

                case AnswerType::NUMBER:
                    $builder->add($fieldName, NumberType::class, [
                        'label' => $label,
                        'required' => false,
                    ]);
                    break;

                case AnswerType::DATE:
                    $builder->add($fieldName, DateType::class, [
                        'label' => $label,
                        'widget' => 'single_text',
                        'required' => false,
                    ]);
                    break;

                case AnswerType::BOOLEAN:
                    $builder->add($fieldName, CheckboxType::class, [
                        'label' => $label,
                        'required' => false,
                    ]);
                    break;

                case AnswerType::SINGLE_CHOICE:
                    $builder->add($fieldName, ChoiceType::class, [
                        'label' => $label,
                        'choices' => $question->getProposalsAsArray(),
                        'expanded' => true,
                        'multiple' => false,
                        'required' => false,
                    ]);
                    break;

                case AnswerType::MULTI_CHOICE:
                    $builder->add($fieldName, ChoiceType::class, [
                        'label' => $label,
                        'choices' => $question->getProposalsAsArray(),
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
