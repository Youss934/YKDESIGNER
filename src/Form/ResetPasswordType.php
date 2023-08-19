<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password', PasswordType::class, [
            
            'label' => 'Votre nouveau mot de passe',
            'attr' => [
                'placeholder' => 'veuillez saisir votre nouveau mot de passe'
            ]
        ])
        
        ->add('new_password_confirme', PasswordType::class, [
            'label' => 'Confirmez votre nouveau mot de passe',
            
            'attr' => [
                'placeholder' => 'veuillez confirmez votre nouveau mot de passe'
            ]
        ])
        


    ->add('firstname', TextType::class, [
        'disabled' => true,
        'label' => 'mon prénom'
    ])
    ->add('lastname', TextType::class, [ 
        'disabled' => true,
        'label' => 'mon nom'
    ])
    ->add ('submit', SubmitType::class,[
        'label' => 'mettre à jour',
        'attr' => [
            'class' => 'btn-block btn-info'
        ]
    ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
