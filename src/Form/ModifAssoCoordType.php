<?php

namespace App\Form;

use App\Entity\Association;
use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ModifAssoCoordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', null, [
                'label' => 'Identifiant',
                'required' => 'true',
                'constraints' => [
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'Votre login doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('email', null, [
                'label' => 'Email',
                'required' => 'true',
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
            ])
            ->add('name', null, [
                'label' => 'Nom',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 32,
                        'maxMessage' => 'Le nom doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('adress', null, [
                'label' => 'Adresse',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 64,
                        'maxMessage' => 'Votre adresse doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('postal_code', null, [
                'label' => 'Code postal',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^$|^[0-9]{5}$/',
                        'message' => 'Votre code postal doit contenir exactement 5 chiffres',
                    ]),
                ],
            ])
            ->add('city', null, [
                'label' => 'Ville',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 48,
                        'maxMessage' => 'Votre ville doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'preferred_choices' => ['FR','BE','DE','IT','LU','ES','CH']
            ])
            ->add('phone', null, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^$|^[0-9]{10}$/',
                        'message' => 'Votre numéro de téléphone doit contenir exactement 10 chiffres',
                    ]),
                ],
            ])
            ->add('url_website', null, [
                'label' => 'Lien du site web',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}