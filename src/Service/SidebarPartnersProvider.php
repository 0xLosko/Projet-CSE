<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Partner;
use Symfony\Component\Validator\Constraints\Length;

class SidebarPartnersProvider
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function getRandomPartners() : array
    {
        $partners = $this->entityManager->getRepository(Partner::class)->findAll();

        if(count($partners) < 3) {
            $partners = ['0' => 'error'];
        } else {
            $randomKeys = array_rand($partners, 3);
            foreach($partners as $key => $partner){
                if(!in_array($key, $randomKeys)){
                    unset($partners[$key]);
                }
            }
        }
        return $partners;
    }
}