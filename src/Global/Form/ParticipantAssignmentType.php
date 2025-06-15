<?php

namespace App\Global\Form;

use App\Global\Entity\ParticipantAssignment;
use App\Global\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantAssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(\Symfony\Component\Form\FormEvents::PRE_SET_DATA, function ($event) {
            $form = $event->getForm();
            $assignment = $event->getData();
            $role = $assignment?->getRole();

            if (!$role) {
                return;
            }

            if ($role->isInternal()) {
                $form->add('internalUser', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'required' => false,
                    'label' => false,
                ]);
            } else {
                $form
                    ->add('externalLastName', TextType::class, ['required' => false, 'label' => 'Nom'])
                    ->add('externalFirstName', TextType::class, ['required' => false, 'label' => 'Prénom'])
                    ->add('externalEmail', EmailType::class, ['required' => false, 'label' => 'Email'])
                    ->add('externalFunction', TextType::class, ['required' => false, 'label' => 'Fonction']);
            }
        });
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParticipantAssignment::class,
        ]);
    }
}
