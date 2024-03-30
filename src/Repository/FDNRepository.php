<?php

namespace App\Repository;

use App\Entity\FDN;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FDN>
 *
 * @method FDN|null find($id, $lockMode = null, $lockVersion = null)
 * @method FDN|null findOneBy(array $criteria, array $orderBy = null)
 * @method FDN[]    findAll()
 * @method FDN[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FDNRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FDN::class);
    }

//    /**
//     * @return FDN[] Returns an array of FDN objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FDN
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
