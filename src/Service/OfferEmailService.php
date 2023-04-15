<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\NewsletterRegistration;
use App\Entity\Offer;
use App\Repository\NewsletterRegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\String\Slugger\SluggerInterface;

class OfferEmailService
{
    private NewsletterRegistrationRepository $newsletterRepo;
    private MailerInterface $mailer;

    public function __construct(NewsletterRegistrationRepository $newsletterRepo, MailerInterface $mailer)
    {
        $this->newsletterRepo = $newsletterRepo;
        $this->mailer = $mailer;
    }

    public function getEligibleEmail(): array
    {
        return $this->newsletterRepo->getEligibleEmail();
    }



    public function sendOfferEmail(Offer $offer, bool $modifiedOffer = false) : void
    {
        $emailNl = $this->getEligibleEmail();

        foreach ($emailNl as $oneEmail)
        {
            $email = (new Email())
                ->from('cse-sv@example.com')
                ->to($oneEmail['emailSubscriber'])
                ->subject(!$modifiedOffer ? 'CSE SV : une nouvelle offre est disponible.' : 'CSE SV : L\'offre '. $offer->getTitleOffer() .' a été modifié')
                ->html('<div>
                                   <H1>'. $offer->getTitleOffer() .'</H1>
                                   <h2>'. $offer->getDescriptionOffer() .'</h2>
                                   <p>Nombre de place : '.$offer->getNumberPlaces().'</p>
                                   <a href="http://localhost:8000/billeterie/'.$offer->getId().'">En savoir plus</a>
                                   
                </div>');

            $this->mailer->send($email);
        }
    }

    public function sendModifiedOfferEmail(Offer $offer) : void
    {

    }
}