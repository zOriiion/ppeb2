<?php

namespace App\Repository;

use App\Entity\ListeMot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListeMot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeMot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeMot[]    findAll()
 * @method ListeMot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeMotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeMot::class);
    }

    // /**
    //  * @return ListeMot[] Returns an array of ListeMot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListeMot
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
