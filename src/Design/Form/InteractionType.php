<?php

namespace App\Design\Form;

use App\Design\Entity\Interaction;
use App\Design\Entity\Element;
use App\Design\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class InteractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champs toujours présents
        $builder
            ->add('label', TextType::class, [
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('dataName', TextType::class, [
                'required' => true,
            ])
            ->add('elementIn', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner un élément source',
            ])
            ->add('elementOut', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner un élément cible',
            ])
            // services toujours présents avec liste vide par défaut (évite les erreurs Twig)
            ->add('serviceIn', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '-- Choisir un service --',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('s')->where('1=0'),
            ])
            ->add('serviceOut', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '-- Choisir un service --',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('s')->where('1=0'),
            ])
            ->add('logic', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 10],
                'label' => 'Logique interne (JSON)',
            ])
        ;

        // Filtrage initial des services selon les éléments sélectionnés
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            if (!$data) return;

            $elementIn = $data->getElementIn();
            $elementOut = $data->getElementOut();

            if ($elementIn) {
                $form->add('serviceIn', EntityType::class, [
                    'class' => Service::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => '-- Choisir un service --',
                    'query_builder' => fn(EntityRepository $er) =>
                        $er->createQueryBuilder('s')->where('s.element = :el')->setParameter('el', $elementIn),
                ]);
            }

            if ($elementOut) {
                $form->add('serviceOut', EntityType::class, [
                    'class' => Service::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'placeholder' => '-- Choisir un service --',
                    'query_builder' => fn(EntityRepository $er) =>
                        $er->createQueryBuilder('s')->where('s.element = :el')->setParameter('el', $elementOut),
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interaction::class,
        ]);
    }
}
