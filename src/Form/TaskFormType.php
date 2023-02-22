<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
use App\Repository\StudentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class TaskFormType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('student', EntityType::class, [
            'class' => Student::class,
            'label' => 'Student',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
           
        ])

        
        
        ->add('subject', EntityType::class, [
            // looks for choices from this entity
            'class' => Subject::class,
            'label' => 'Subject',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'choice_label' => 'name',
        ])
        ->add('grade', EntityType::class, [
            // looks for choices from this entity
            'class' => Grade::class,
            'label' => 'Grade',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'choice_label' => 'name'
            
        ])
            
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800'
            ],
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