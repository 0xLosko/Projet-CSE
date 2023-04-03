<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerSurveyController extends AbstractController
{
    #[Route('/answerSurvey', name: 'answer', methods:"POST")]
    public function index(
        EntityManagerInterface $em, 
        Request $request,
        QuestionRepository $questionRepository)
    {
        $session = $request->getSession();
        $answer = new Answer();
        $activeQuestion = $questionRepository->findOneBy(
            array('available' => 1)
        );

        $form = $this->createForm(AnswerType::class, $answer, [
            'question' => $activeQuestion
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            $answer->setDateAnswer(new \DateTime());
            
            // faire un try catch
            $em->persist($answer);
            $em->flush();
            $session->getFlashBag()->add('success', 'Votre réponse a bien été envoyée.');
        }

        $referer = $request->headers->get('referer');
        $refererPathInfo  = Request::create($referer)->getPathInfo();

        return $this->redirect($refererPathInfo);
    }

    #[Route('/backoffice/gerer-sondage', name: 'manage_survey')]
    public function manageSurvey(): Response
    {
        // $responseContent = new ContentPage();

        return $this->render('security/backoffice/manage_survey/index.html.twig', [
            'test' => 'test',
        ]);
    }
}
