<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             // Ajouter des champs de formulaire avec la classe 'form-control' de Bootstrap pour le style
            ->add('name', null, ['attr' => ['class' => 'form-control']])
            ->add('description', null, ['attr' => ['class' => 'form-control']])
            ->add('adress', null, ['attr' => ['class' => 'form-control']])
            ->add('postal_code', null, ['attr' => ['class' => 'form-control']])
            ->add('city', null, ['attr' => ['class' => 'form-control']])
            ->add('country', null, ['attr' => ['class' => 'form-control']])
            ->add('phone', null, ['attr' => ['class' => 'form-control']])
            ->add('email', null, ['attr' => ['class' => 'form-control']])
            ->add('url_website', null, ['attr' => ['class' => 'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
    
}
