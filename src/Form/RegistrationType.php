<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'id' => 'firstname',
                    'placeholder' => 'Prénom',
                    'minlenght' => '2',
                    'maxlenght' => '30',
                    'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                ],
                
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 30])
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                    'id' => 'lastname',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                    'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'E-mail',
                    'id' => 'email',
                    'minlenght' => '2',
                    'maxlenght' => '255',
                    'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 255])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'invalid_message' => 'Les deux mots de passe ne correspondent pas.',
                'attr' => [
                    'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                ],
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'id' => 'password1',
                        'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                    ],
                    
                    'label' => false
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Confirmer le mot de passe',
                        'id' => 'password2',
                        'class' => 'w-full px-5 py-3 text-base transition bg-transparent border rounded-md outline-none border-stroke dark:border-dark-3 text-body-color dark:text-dark-6 placeholder:text-dark-6 focus:border-primary dark:focus:border-primary focus-visible:shadow-none'
                    ],
                    'label' => false
                ],
                'error_bubbling' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'id' => 'submit',
                    'class' => 'w-full px-5 py-3 text-base text-white transition duration-300 ease-in-out border rounded-md cursor-pointer border-primary bg-primary hover:bg-blue-dark'
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