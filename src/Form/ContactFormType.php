<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use PixelOpen\CloudflareTurnstileBundle\Type\TurnstileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Prénom :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Mail :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre adresse e-mail',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message :',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre message',
                    ]),
                ],
            ])
            ->add('subscribeToNewsletter', CheckboxType::class, [
                'label' => 'S\'inscrire à la newsletter ?',
                'required' => false,
            ])
            ->add('security', TurnstileType::class, [
                'attr' => ['data-action' => 'contact'],
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        // Configure your form options here
        ]);
    }
}
