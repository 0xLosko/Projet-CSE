<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\AnswerRepository;
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
        QuestionRepository $questionRepository
    ): Response
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
    public function manageSurvey(
        Request $request,
        QuestionRepository $questionRepository,
    ): Response
    {
        $session = $request->getSession();
        $activeQuestion = $questionRepository->findOneBy(
            array('available' => 1)
        );
        $surveys = $questionRepository->findAll();

        $questionForm = $this->createForm(QuestionType::class);
        $questionForm->handleRequest($request);
        if($questionForm->isSubmitted() && $questionForm->isValid()) {
            $activeQuestion->setTextQuestion($questionForm->getData()->getTextQuestion());
            // try catch
            $questionRepository->save($activeQuestion, true);
            $session->getFlashBag()->add('success', 'La modification de la question du sondage a été effectuée.');
        }

        return $this->render('security/backoffice/manage_survey/index.html.twig', [
            'activeQuestion' => $activeQuestion,
            'surveys' => $surveys,
            'questionForm' => $questionForm,
        ]);
    }

    #[Route('/backoffice/gerer-sondage/nouveau-sondage', name: 'new_survey')]
    public function newSurvey(
        Request $request,
        AnswerRepository $answerRepository,
    ): Response
    {
        return $this->render('security/backoffice/manage_survey/new.html.twig');
    }

    #[Route('/backoffice/gerer-sondage/{id}/activer', name: 't_on_survey')]
    public function turnOnSurvey(
        Request $request,
        int $id,
        QuestionRepository $questionRepository,
    ): Response
    {
        $session = $request->getSession();
        // désactiver le sondage actif
        $activeQuestion = $questionRepository->findOneBy(
            array('available' => 1)
        );
        if($activeQuestion != null) {
            $activeQuestion->setAvailable(0);
            $questionRepository->save($activeQuestion, true);
        }

        $newActive = $questionRepository->findOneBy(['id' => $id]);
        $newActive->setAvailable(1);
        // faire un try catch
        $questionRepository->save($newActive, true);
        $session->getFlashBag()->add('success', 'Le sondage a bien été activé.');

        return $this->redirectToRoute('manage_survey');
    }

    #[Route('/backoffice/gerer-sondage/desactiver-sondage', name: 't_off_survey')]
    public function turnOffSurvey(
        Request $request,
        QuestionRepository $questionRepository,
    ): Response
    {
        $session = $request->getSession();
        $activeQuestion = $questionRepository->findOneBy(
            array('available' => 1)
        );
        $activeQuestion->setAvailable(0);
        // try catch
        $questionRepository->save($activeQuestion, true);
        $session->getFlashBag()->add('success', 'Le sondage a bien été désactivé.');

        return $this->redirectToRoute('manage_survey');
    }

    // premet de consulter les stats de n'importe quel sondage
    #[Route('/backoffice/gerer-sondage/{id}', name: 'show_survey')]
    public function statisticSurvey(
        int $id,
        Request $request,
        QuestionRepository $questionRepository,
    ): Response
    {
        $session = $request->getSession();
        $selectedQuestion = $questionRepository->findOneBy(['id'=>$id]);

        $questionForm = $this->createForm(QuestionType::class);
        $questionForm->handleRequest($request);
        if($questionForm->isSubmitted() && $questionForm->isValid()) {
            $selectedQuestion->setTextQuestion($questionForm->getData()->getTextQuestion());
            // try catch
            $questionRepository->save($selectedQuestion, true);
            $session->getFlashBag()->add('success', 'La modification de la question du sondage a été effectuée.');
        }

        return $this->render('security/backoffice/manage_survey/one_survey.html.twig', [
            'activeQuestion' => $selectedQuestion,
            'questionForm' => $questionForm,
        ]);
    }
}
