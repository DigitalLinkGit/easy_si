<?php
namespace App\Capture\Form;

use App\Capture\Entity\QuestionInstance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionInstanceRenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('renderTemplate', TextareaType::class, [
                'label' => 'Modèle de rendu',
                'attr' => ['class' => 'form-control', 'rows' => 8],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuestionInstance::class,
        ]);
    }
}
