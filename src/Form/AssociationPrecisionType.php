<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AssociationPrecisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new Length([
                        'max' => 32,
                        'maxMessage' => 'Le nom doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('description', null, ['attr' => ['class' => 'form-control']])
            ->add('adress', null, [
                'constraints' => [
                    new Length([
                        'max' => 64,
                        'maxMessage' => 'Votre adresse doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('postal_code', null, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^$|^[0-9]{5}$/',
                        'message' => 'Votre code postal doit contenir exactement 5 chiffres',
                    ]),
                ],
            ])
            ->add('city', null, [
                'constraints' => [
                    new Length([
                        'max' => 48,
                        'maxMessage' => 'Votre ville doit contenir moins de {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('country', CountryType::class, [
                'attr' => ['class' => 'form-control'],
                'preferred_choices' => ['FR','BE','DE','IT','LU','ES','CH']
            ])
            ->add('phone', null, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^$|^[0-9]{10}$/',
                        'message' => 'Votre numéro de téléphone doit contenir exactement 10 chiffres',
                    ]),
                ],
            ])
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