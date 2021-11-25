<?php

namespace App\Repository;

use App\Entity\WebsiteStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WebsiteStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteStatus[]    findAll()
 * @method WebsiteStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteStatus::class);
    }

    public function findLastStatusByWebsiteId($value)
    {
        return $this->createQuery(
            'SELECT w.status FROM WebsiteStatus w WHERE w.created_at > CURRENT_DATE() and w.website_id=":val"'
            )
            ->setParameter('val', $value)
            ->setMaxResults(1);
        ;
    }

    public function findAllCreatedAtByWebsiteId($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT  w.status, w.created_at 
            FROM App\Entity\WebsiteStatus w 
            WHERE w.website= :val'
            )->setParameter('val', $value);

        return $query->getResult();
    }

    

    // /**
    //  * @return WebsiteStatus[] Returns an array of WebsiteStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WebsiteStatus
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
