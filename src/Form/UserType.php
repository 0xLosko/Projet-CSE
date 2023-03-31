<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le nom d\'utilisateur'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom d\'utilisateur ne peut pas être vide.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe:',
                'required' => ($options['isModify'] ? false : true),
                'attr' => [
                    'placeholder' => 'Entrez le mot de passe'
                ],
                'constraints' => ($options['isModify'] && empty($builder->getData()->getPassword()) ? [] : [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 1 caractère spécial, 1 majuscule, 1 minuscule, 1 chiffre et au moins 7 caractères au total.'
                    ]),
                ]),
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if (empty($data['password'])) {
                    $user = $form->getData();
                    $data['password'] = $user->getPassword();
                }

                $event->setData($data);
            });
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isModify' => false,
        ]);
        $resolver->setAllowedTypes('isModify', 'bool');
    }
}
