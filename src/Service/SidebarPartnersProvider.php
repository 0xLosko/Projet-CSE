<?php
namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Partner;

class sidebarPartnersProvider
{
    public function getRandomPartners(ManagerRegistry $em): array
    {
        $partners = $em->getRepository(Partner::class)->findAll();
        $randomKeys = array_rand($partners, 3);
        foreach($partners as $key => $partner){
            if(!in_array($key, $randomKeys)){
                unset($partners[$key]);
            }
        }
        return $partners;
    }
}