<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Proposal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('textQuestion')
            ->add('proposals', EntityType::class, [
                'class' => Proposal::class,
                'choice_label' => 'textProposal',
                // 'entry_options' => ['label' => false],
                'expanded' => true,
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
