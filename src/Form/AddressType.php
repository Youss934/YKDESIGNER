<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'quel nom souhaitez-vous donner à votre addresse',
                'attr' => [
                    'placeholder' => 'nommez votre addresse'
                ]])
            ->add('lastName',TextType::class, [
                'label' => 'quel est votre nom',
                'attr' => [
                    'placeholder' => 'mentionnez votre nom'
                ]])
            ->add('firstName',TextType::class, [
                'label' => 'quel est votre prenom',
                'attr' => [
                    'placeholder' => 'mentionnez votre prenom'
                ]])
            ->add('company',TextType::class, [
                'label' => 'votre societe',
                'attr' => [
                    'placeholder' => '(facultatif)nommez votre societe',
                    'required' => false
                ]])
            ->add('adress',TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => '5 rue michel carre'
                ]])
            ->add('postal',TextType::class, [
                'label' => 'votre code postal',
                'attr' => [
                    'placeholder' => 'ecrivez votre code postal'
                ]])
            ->add('city',TextType::class, [
                'label' => 'votre ville de residence',
                'attr' => [
                    'placeholder' => 'argenteuil'
                ]])
            ->add('country',CountryType::class, [
                'label' => 'quel est votre pays de residence',
                'attr' => [
                    'placeholder' => ' votre pays'
                ]])
            ->add('phone',TelType::class, [
                'label' => 'quel est votre numero de telephone',
                'attr' => [
                    'placeholder' => 'nommez votre addresse'
                ]])
            ->add('submit',SubmitType::class ,[
                'label' => 'ajouter mon addresse',
                'attr' => [
                    'class' => 'btn-block btn-info'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
