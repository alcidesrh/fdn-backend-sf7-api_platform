<?php

namespace App\Repository;

use App\Entity\ParadaIntermedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParadaIntermedia>
 *
 * @method ParadaIntermedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParadaIntermedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParadaIntermedia[]    findAll()
 * @method ParadaIntermedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParadaIntermediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParadaIntermedia::class);
    }

//    /**
//     * @return ParadaIntermedia[] Returns an array of ParadaIntermedia objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParadaIntermedia
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
