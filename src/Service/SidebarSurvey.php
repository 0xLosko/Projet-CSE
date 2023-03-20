<?php
namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Question;
use App\Entity\Proposal;
use App\Entity\Answer;

class SidebarSurvey
{
    public function getQuestionSurvey(ManagerRegistry $em): Question
    {
        $question = $em->getRepository(Question::class)->findOneBy(array('available' => 1));

        return $question;
    }

    public function getProposalsSurvey(ManagerRegistry $em, Question $question): array
    {
        $proposals = $em->getRepository(Proposal::class)->findBy(array('question' => $question));

        return $proposals;
    }
}