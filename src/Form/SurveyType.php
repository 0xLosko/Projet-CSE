<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('textQuestion', TextType::class, [
                'label' => 'Question',
            ])
            ->add('proposals', CollectionType::class, [
                'label' => 'Propositions',
                'entry_type' => ProposalType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            ->add('available', CheckboxType::class, [
                'label' => 'Activer le sondage',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
