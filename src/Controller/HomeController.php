<?php

namespace App\Controller;

use App\Entity\Proposal;
use App\Entity\Answer;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Form\SurveyType;
use App\Repository\QuestionRepository;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\SidebarPartnersProvider;
use App\Service\SidebarSurvey;
use Symfony\Component\HttpFoundation\Request;
class HomeController extends AbstractController
{
    #[route(path: "/", name: "home")]
    public function home (
        ManagerRegistry $em, 
        SidebarPartnersProvider $sidePartners, 
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        Request $request): Response
    {
        $rdmPartners = $sidePartners->getRandomPartners();
        $answer = new Answer();

        $activeQuestion = $questionRepository->findOneBy(
            array('available' => 1)
        );

        $formSurvey = $this->createForm(AnswerType::class, $answer, [
            'question' => $activeQuestion
        ]);
        $formSurvey->handleRequest($request);

        if ($formSurvey->isSubmitted() && $formSurvey->isValid()) {
            dd($formSurvey);
        }


        return $this->render('home/index.html.twig', [
            'rdmPartners' => $rdmPartners,
            'formSurvey' => $formSurvey->createView(),
            'txtQuestion' => $activeQuestion->getTextQuestion(),
        ]);
    }
}