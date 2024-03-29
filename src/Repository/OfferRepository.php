<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *
     */
    public function findOfferPaginated(int $page,int $typeOffer,int $limit = 3): array
    {
        $limit = abs($limit);

        $result = [];
        if($typeOffer != 2){
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('o')
                ->from('App\Entity\Offer', 'o')
                ->where("o.typeOffer = '$typeOffer'")
                ->andWhere('o.startDateDisplay <= CURRENT_DATE()')
                ->andWhere('o.endDateDisplay   >= CURRENT_DATE()')
                ->setMaxResults($limit)
                ->setFirstResult(($page * $limit) - $limit);
            //limited Offers
            if($typeOffer == 0){
                $query->andWhere('o.sortNumber > 0')
                    ->orderBy('o.sortNumber', 'DESC');
            }
        } else {
            //all Offers
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('o')
                ->from('App\Entity\Offer', 'o')
                ->where('o.startDateDisplay <= CURRENT_DATE()')
                ->andWhere('o.endDateDisplay   >= CURRENT_DATE()')
                ->setMaxResults($limit)
                ->setFirstResult(($page * $limit) - $limit)
                ->orderBy('o.endDateDisplay', 'ASC');
        }

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();
        if(empty($data)){
            return $result;
        }
        //pages rounded up to the next highest integer.
        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        return $result;
    }
}
