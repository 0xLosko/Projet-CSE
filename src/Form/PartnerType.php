<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez une description'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le lien'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le lien ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('file', FileType::class, [
                'label' => 'Logo:',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le fichier ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('nameFile', TextType::class, [
                'label' => 'Nom du logo:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le nom du logo'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de fichier ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('nameAltFile', TextType::class, [
                'label' => 'Nom alternatif du logo:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le nom alternatif du logo'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de fichier ne peut pas être vide.',
                    ]),
                ],
            ]);
    }

}
