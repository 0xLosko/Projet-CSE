<?php

namespace App\Controller;

use App\Entity\NewsletterRegistration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SubscribeNewsletterController extends AbstractController
{
    #[Route('/subscribe', name: 'subscribe', methods:"POST")]
    public function index(
        EntityManagerInterface $em, 
        Request $request)
    {
        $subscriber = new NewsletterRegistration();
        $session = $request->getSession();

        $email = filter_var($request->request->get('email'), FILTER_VALIDATE_EMAIL);
        if($email) {
            $subscriber->setEmailSubscriber($email);
            $subscriber->setDateSubscriber(new \DateTime());
            $subscriber->setCguAccepted(true);
            // faire un try catch
            $em->persist($subscriber);
            $em->flush();
            $session->getFlashBag()->add('success', 'Votre inscription a bien été effectuée.');
        }

        $referer = $request->headers->get('referer');
        $refererPathInfo  = Request::create($referer)->getPathInfo();

        return $this->redirect($refererPathInfo);
    }
}