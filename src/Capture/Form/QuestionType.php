<?php

namespace App\Capture\Form;

use App\Capture\Entity\Question;
use App\Capture\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Identifiant',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
                'required' => false,
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'form-control', 'rows' => 3],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('multipleChoice', CheckboxType::class, [
                'label' => 'Question à choix multiple',
                'required' => false,
                'row_attr' => ['class' => 'form-check mb-3'],
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label'],
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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $question = $event->getData();
            $form = $event->getForm();

            if (!$question instanceof Question) {
                return;
            }

            $hasProposals = count($question->getProposals()) > 0;
            $answerType = $hasProposals ? 'proposed' : 'open';

            $form->add('answerType', ChoiceType::class, [
                'label' => 'Type de réponse',
                'choices' => [
                    'Réponse ouverte' => 'open',
                    'Réponses proposées' => 'proposed',
                ],
                'mapped' => false,
                'required' => true,
                'data' => $answerType,
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'mb-3'],
            ]);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {   
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
