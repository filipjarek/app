<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
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
        ])
        ->add('subject', EntityType::class, [          
            'class' => Subject::class,
            'label' => 'Subject',            
            'choice_label' => 'name',
        ])
        ->add('grade', EntityType::class, [          
            'class' => Grade::class,
            'label' => 'Grade',
            'choice_label' => 'name'
        ])
            
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