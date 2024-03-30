<?php

namespace App\Repository;

use App\Entity\Recorrido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recorrido>
 *
 * @method Recorrido|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recorrido|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recorrido[]    findAll()
 * @method Recorrido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecorridoRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Recorrido::class);
    }

    //    /**
    //     * @return Recorrido[] Returns an array of Recorrido objects
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

    //    public function findOneBySomeField($value): ?Recorrido
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
