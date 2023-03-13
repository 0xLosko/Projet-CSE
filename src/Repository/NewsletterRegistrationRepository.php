<?php

namespace App\Repository;

use App\Entity\NewsletterRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterRegistration>
 *
 * @method NewsletterRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterRegistration[]    findAll()
 * @method NewsletterRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterRegistration::class);
    }

    public function save(NewsletterRegistration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NewsletterRegistration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NewsletterRegistration[] Returns an array of NewsletterRegistration objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewsletterRegistration
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
