<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        
        ->add('firstname', TextType::class, [
            'label' => 'prenom',
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'veuillez renseigner votre prénom'
            ]

        ])
        ->add('lastname', TextType::class, [
            'label' => 'nom',
            'constraints' => new Length(['min' => 2,
            'max' => 30]),
            'attr' => [
                'placeholder' => 'veuillez renseigner votre nom'
            ]
        ])

        ->add('email', EmailType::class, [
            'label' => 'email',
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'veuillez renseigner votre adresse mail'
            ]
        ])

        ->add('password', PasswordType::class, [
            'label' => 'Votre mot de passe',
            'attr' => [
                'placeholder' => 'veuillez saisir un mot de passe'
            ]
        ])

        ->add('password_confirme', PasswordType::class, [
            'label' => 'Confirmez votre mot de passe',
            'mapped' => false,
            'attr' => [
                'placeholder' => 'veuillez saisir un mot de passe'
            ]
        ])

        ->add('submit', SubmitType::class, [
            'label' => 's\'inscrire' // Ajoutez un backslash avant l'apostrophe pour échapper le caractère
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
       


    }
}
