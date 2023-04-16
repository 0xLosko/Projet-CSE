<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Proposal;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $questionId = $builder->getOption('question')->getId();

        $builder
            ->add('proposal', EntityType::class, [
                'class' => Proposal::class,
                'query_builder' => function (EntityRepository $er) use($questionId) {
                    return $er->createQueryBuilder('p')
                        ->where('p.question = :id')
                        ->setParameter('id', $questionId);
                },
                'choice_label' => 'textProposal',
                'expanded' => true,
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'save action-btn'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
        $resolver->setRequired('question');
    }
}
