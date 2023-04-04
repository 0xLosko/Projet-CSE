<?php

namespace App\Form;

use App\Entity\Offer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleOffer', TextType::class, [
                'label' => 'Titre de l\'offre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le titre ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('descriptionOffer', TextType::class, [
                'label' => 'Description de l\'offre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('typeOffer', ChoiceType::class, [
                'label' => 'Type de l\'offre',
                'choices' => [
                    'Type d\'offre' => [
                        'Limité' => '0',
                        'Permanents' => '1',
                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le type ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('linkOffer', TextType::class, [
                'label' => 'Lien de l\'offre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le lien ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('startDateDisplay', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de début ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('endDateDisplay', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de fin ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('sortNumber', IntegerType::class, [
                'label' => 'Numéro d\'importance',
                'required' => false,
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 10,
                        'notInRangeMessage' => 'Le numéro d\'importance doit être entre {{ min }} et {{ max }}',
                    ]),
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ])
            ->add('startDateValid', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDateValid', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('numberPlaces', TextType::class, [
                'label' => 'Nombre de places',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
