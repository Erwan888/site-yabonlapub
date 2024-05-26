<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ModifUserCoordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', null, [
                'label' => 'Identifiant',
                'constraints' => [
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Votre login doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('email', null, [
                'label' => 'Email',
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Votre email doit contenir moins de {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message' => 'Votre email ne respecte pas le format standard',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}