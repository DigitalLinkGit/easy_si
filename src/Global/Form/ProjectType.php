<?php

namespace App\Global\Form;

use App\Global\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Global\Form\ParticipantAssignmentType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Project $project */
        $project = $options['data'];

        // Initialisation des affectations (si vide)
        if ($project->getParticipantAssignments()->isEmpty()) {
            foreach ($project->getAllRolesFromCaptures() as $role) {
                $assignment = new \App\Global\Entity\ParticipantAssignment();
                $assignment->setProject($project);
                $assignment->setRole($role);
                $project->addParticipantAssignment($assignment);
            }
        }

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de l\'élémént...',
                ],
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Draft' => 'draft',
                    'Validé' => 'released',
                    'En cours' => 'in-progress',
                    'Terminé' => 'finished',
                    'Annulé' => 'cancelled',
                ],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'placeholder' => 'Description de la capture...',
                ],
            ])
            ->add('participantAssignments', CollectionType::class, [
                'entry_type' => ParticipantAssignmentType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
