<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use App\Repository\FileRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;


class PartnershipController extends AbstractController
{
    #[Route('/partenariats', name: 'partnership')]
    public function index(ManagerRegistry $em): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(true);

        return $this->render('partnership/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/partenariats/tous-les-partenaires/', name: 'partnership-all')]
    public function allPartners(ManagerRegistry $em): Response
    {
        $partners = $em->getRepository(Partner::class)->getPartners(false);
        
        return $this->render('partnership/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires', name: 'manage_partners', methods: ['GET'])]
    public function manage_partners(PartnerRepository $partnerRepository): Response
    {
        return $this->render('security/backoffice/manage_partners/index.html.twig', [
            'partners' => $partnerRepository->findAll(),
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/nouveau', name: 'app_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, PictureService $pictureService): Response
    {
        $form = $this->createForm(PartnerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $response = $form->getData();
            //file insert
            $fileResponse = $response['file'];
            $file = $pictureService->add($fileResponse, $response['nameFile'], $response['nameAltFile'], null);

            //insert partner
            $partner = new Partner();
            $partner->setName($response['name']);
            $partner->setDescription($response['description']);
            $partner->setLink($response['link']);
            $partner->setIdFile($file);

            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/backoffice/manage_partners/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/{id}/modifier', name: 'app_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository, SluggerInterface $slugger, FileRepository $fileRepository): Response
    {
        $form = $this->createForm(PartnerType::class,null,[
            'isModify' => true,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Response = $form->getData();
            //update file
            $fileResponse = $Response['file'];
            if(isset($fileResponse)){
                $originalFileName = pathinfo($fileResponse->getClientOriginalName(), PATHINFO_FILENAME);
                $file = new File();
                $file->setOriginalName($fileResponse->getClientOriginalName());
                $file->setFileName($Response['nameFile']);
                $file->setAltFile($Response['nameAltFile']);
                $file->setSizeFile($fileResponse->getSize());
                $file->setDateFile(new \DateTime());

                $safeFilename = $slugger->slug($originalFileName);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileResponse->guessExtension();
                try {
                    $fileResponse->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd('Erreur lors de l\'insertion de l\'image, contactez un administrateur' . $e);
                }

                //delete old file in Server Storage
                $fileOld = $partner->getIdFile()->getPathFile();
                $pattern = "/\/uploads\/file\//";
                $newFile = preg_replace($pattern, "", $fileOld);
                unlink($this->getParameter('file_directory') . '/' . $newFile);
                //save new file
                $file->setPathFile('/uploads/file/' . $newFilename);
                $fileRepository->save($file);

                //update partner
                $partner->setName($Response['name']);
                $partner->setDescription($Response['description']);
                $partner->setLink($Response['link']);
                $partner->setIdFile($file);

            }
            else
            {
                $partner->setName($Response['name']);
                $partner->setDescription($Response['description']);
                $partner->setLink($Response['link']);
            }
            $partnerRepository->save($partner, true);

            return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('security/backoffice/manage_partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('backoffice/gerer-les-partenaires/{id}', name: 'app_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository, FileRepository $fileRepository): Response
    {
        $file = $partner->getIdFile()->getPathFile();
        $pattern = "/\/uploads\/file\//";
        $newFile = preg_replace($pattern, "", $file);
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            unlink($this->getParameter('file_directory') . '/' . $newFile);
            $fileRepository->remove($partner->getIdFile(), true);
            $partnerRepository->remove($partner, true);
        }

        return $this->redirectToRoute('manage_partners', [], Response::HTTP_SEE_OTHER);
    }
}
