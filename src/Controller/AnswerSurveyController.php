<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * I am using a PHP trait to isolate each snippet in a file.
 * This code should be called from a Symfony controller extending AbstractController (as of Symfony 4.2)
 * or Symfony\Bundle\FrameworkBundle\Controller\Controller (Symfony <= 4.1).
 * Services are injected in the main controller constructor.
 *
 * @property RouterInterface $router
 */
class AnswerSurveyController extends AbstractController
{
    #[Route('/answerSurvey', name: 'answer', methods:"POST")]
    public function index(
        EntityManagerInterface $em, 
        Request $request,
        QuestionRepository $questionRepository)
    {
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
        }

        $referer = $request->headers->get('referer');
        $refererPathInfo  = Request::create($referer)->getPathInfo();

        return $this->redirect($refererPathInfo);
    }
}
