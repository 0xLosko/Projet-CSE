<?php

namespace App\Service;

use App\Entity\File;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureService
{
    private $params;
    private $slugger;
    private $em;

    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->slugger = $slugger;
        $this->em = $em;
    }

    public function add(UploadedFile $fileResponse, ?string $fileName, ?string $nameAltFile, ?Offer $relatedOffer)
    {
        $originalFileName = pathinfo($fileResponse->getClientOriginalName(), PATHINFO_FILENAME);
        $file = new File();
        $file->setOriginalName($fileResponse->getClientOriginalName());
        $file->setFileName($fileName ?? $fileResponse->getClientOriginalName());
        $file->setAltFile($nameAltFile ?? $fileResponse->getClientOriginalName());
        $file->setSizeFile($fileResponse->getSize());
        $file->setDateFile(new \DateTime());
        if(isset($relatedOffer)) {
            $file->setOffer($relatedOffer);
        }

        $safeFilename = $this->slugger->slug($originalFileName);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileResponse->guessExtension();

        try {
            $fileResponse->move(
                $this->params->get('file_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            throw new Exception('Erreur lors de l\'insertion de l\'image, contactez un administrateur' . $e);
        }

        $file->setPathFile('/uploads/file/' . $newFilename);

        try {
            $this->em->persist($file);
            $this->em->flush();
        } catch(Exception $e) {
        $this->redirectToRoute('manage_home');
        $this->addFlash('error', 'Erreur lors de l\'insertion de l\'image, contactez un administrateur' . $e);
        }

        return $file;
    }
}