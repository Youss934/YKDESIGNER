<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Correction ici
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'mon adresse e-mail'
            ])
            ->add('old_password',PasswordType::class,[
                'mapped' => false,
                'label' => 'mon mot de passe actuel',
                'attr' => ['placeholder' => 'veuillez saisir votre mot de passe actuel']])

                ->add('new_password', PasswordType::class, [
                    'mapped' => false,
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'veuillez saisir votre nouveau mot de passe'
                    ]
                ])
                
                ->add('new_password_confirme', PasswordType::class, [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'mapped' => false, 
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
                'label' => 'mettre à jour'
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
