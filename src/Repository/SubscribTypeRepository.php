<?php

namespace App\Repository;

use App\Entity\SubscribType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscribType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscribType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscribType[]    findAll()
 * @method SubscribType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscribTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscribType::class);
    }

    // /**
    //  * @return SubscribType[] Returns an array of SubscribType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubscribType
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
