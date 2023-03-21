<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'label' => 'Student',
                'disabled' => 'true',
            ])
            ->add('subject', EntityType::class, [
                'class' => Subject::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.id', 'ASC');
                },
                'label' => 'Subject',
                'placeholder' => 'Choose an option',
            ])
            ->add('grade', EntityType::class, [
                'class' => Grade::class,
                'label' => 'Grade',
                'placeholder' => 'Choose an option',
            ])
            ->add('description', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Add description...'
                )
           ))

            ->add('submit', SubmitType::class, [
                'label' => 'Submit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
