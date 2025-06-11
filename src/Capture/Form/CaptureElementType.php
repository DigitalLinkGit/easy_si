<?php
// src/Form/CaptureElementType.php
namespace App\Capture\Form;

use App\Global\Entity\ParticipantRole;
use App\Global\Repository\ParticipantRoleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Capture\Entity\CaptureElement;

class CaptureElementType extends AbstractType
{
    private ParticipantRoleRepository $roleRepository;

    public function __construct(ParticipantRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de l\'élémént...',
                ],
                'required' => true,
            ])
            ->add('respondentRole', EntityType::class, [
                'class' => ParticipantRole::class,
                'choices' => $this->roleRepository->findBy(['isInternal' => false]),
                'choice_label' => 'name',
                'label' => 'Rôle du répondant',
            ])
            ->add('validatorRole', EntityType::class, [
                'class' => ParticipantRole::class,
                'choices' => $this->roleRepository->findBy(['isInternal' => true]),
                'choice_label' => 'name',
                'label' => 'Rôle du validateur',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CaptureElement::class,
        ]);
    }
}
