<?php

namespace App\Repository;

use App\Entity\Piloto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Piloto>
 *
 * @method Piloto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Piloto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Piloto[]    findAll()
 * @method Piloto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PilotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Piloto::class);
    }

//    /**
//     * @return Piloto[] Returns an array of Piloto objects
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

//    public function findOneBySomeField($value): ?Piloto
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
