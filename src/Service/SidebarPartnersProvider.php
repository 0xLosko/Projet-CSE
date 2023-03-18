<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Partner;

class SidebarPartnersProvider
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function getRandomPartners(): array
    {
        $partners = $this->entityManager->getRepository(Partner::class)->findAll();
        $randomKeys = array_rand($partners, 3);
        foreach($partners as $key => $partner){
            if(!in_array($key, $randomKeys)){
                unset($partners[$key]);
            }
        }
        return $partners;
    }
}