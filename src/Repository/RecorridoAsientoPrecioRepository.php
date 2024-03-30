<?php

namespace App\Repository;

use App\Entity\RecorridoAsientoPrecio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecorridoAsientoPrecio>
 *
 * @method RecorridoAsientoPrecio|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecorridoAsientoPrecio|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecorridoAsientoPrecio[]    findAll()
 * @method RecorridoAsientoPrecio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecorridoAsientoPrecioRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, RecorridoAsientoPrecio::class);
    }

    //    /**
    //     * @return RecorridoAsientoPrecio[] Returns an array of RecorridoAsientoPrecio objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RecorridoAsientoPrecio
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
