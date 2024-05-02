<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class Inscription extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', EmailType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('Ville', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('Password', EmailType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('ConfirmationPassword', TextType::class, [
                'label' => 'Confirmation du mot de passe',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}