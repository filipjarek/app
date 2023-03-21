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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => ['placeholder' => 'Dylan']
            ])
            ->add('lastname', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => ['placeholder' => 'Jones']
            ])
            ->add('username', TextType::class, [
                'label_attr' => [
                    'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                ],
                'attr' => ['placeholder' => 'djones']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'required' => true,
                'type' => PasswordType::class,
                'invalid_message' => 'The passwords do not match.',
                'first_options' => [
                    'label' => 'New password',
                    'label_attr' => [
                        'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                    ],
                    'attr' => ['placeholder' => 'Password'],
                    'constraints' => [
                        new Length(['min' => 8, 'max' => 32]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm password',
                    'label_attr' => [
                        'class' => 'form-label block text-sm font-medium text-gray-900 dark:text-white'
                    ],
                    'attr' => ['placeholder' => 'Confirm Password']
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
