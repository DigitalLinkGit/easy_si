<?php

namespace App\Capture\Form;

use App\Capture\Entity\Question;
use App\Capture\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Capture\Enum\AnswerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Identifiant',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'col-4'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de réponse',
                'choices' => [
                    'Texte libre' => AnswerType::TEXT,
                    'Numérique' => AnswerType::NUMBER,
                    'Date' => AnswerType::DATE,
                    'Oui / Non' => AnswerType::BOOLEAN,
                    'Choix unique' => AnswerType::SINGLE_CHOICE,
                    'Choix multiple' => AnswerType::MULTI_CHOICE,
                ],
                'choice_label' => fn($choice, $key, $value) => $key,
                'choice_value' => fn(?AnswerType $type) => $type?->value,
                'attr' => ['class' => 'form-select', 'id' => 'question_type'],
                'row_attr' => ['class' => 'col-4'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'form-control', 'rows' => 3],
                'row_attr' => ['class' => 'mb-3'],
            ])

            ->add('proposals', CollectionType::class, [
                'entry_type' => ProposalType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => false,
                'attr' => ['data-controller' => 'collection'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
