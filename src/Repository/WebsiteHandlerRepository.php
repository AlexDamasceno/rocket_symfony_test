<?php

namespace App\Repository;

use App\Entity\WebsiteHandler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WebsiteHandler|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteHandler|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteHandler[]    findAll()
 * @method WebsiteHandler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteHandlerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteHandler::class);
    }

    // /**
    //  * @return WebsiteHandler[]
    //  */
    // public function findAllWebsites(): array
    // {
    //     return $this->createQueryBuilder('w')
    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * @return WebsiteHandler[] Returns an array of WebsiteHandler objects
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
    public function findOneBySomeField($value): ?WebsiteHandler
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
