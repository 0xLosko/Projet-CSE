<?php

namespace App\Controller;

use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use App\Service\SidebarPartnersProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SidebarController extends AbstractController
{
    public function sidebarBuilder(
        QuestionRepository $questionRepository,
        Request $request,
        SidebarPartnersProvider $sidePartners): Response
    {
        $rdmPartners = $sidePartners->getRandomPartners();
        $activeQuestion = $questionRepository->getActiveSurvey();

        if ($activeQuestion != null){
            $form = $this->createForm(AnswerType::class, null, [
                'action' => $this->generateUrl('answer'), // on spécifie l'action sur laquelle on va transmettre nos données.
                'method' => 'POST',
                'question' => $activeQuestion
            ]);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                $data = $request->request->get('proposal');

                return $this->redirectToRoute('contact');
            }else{
                $data = $request->request->get('proposal');
            }
            $view = $form->createView();
        }
        else {
            $view = null;
            $data = null;
        }

        return $this->render('base/sidebar.html.twig', [
            'form' => $view,
            'survey' => $activeQuestion,
            'rdmPartners' => $rdmPartners,
            'data' => $data,
        ]);
    }
}
