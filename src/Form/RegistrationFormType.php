<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType; 

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                
            ])
           
            ->add('lastname', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
               
            ])
            ->add('username', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Password',
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
