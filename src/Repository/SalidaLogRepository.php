<?php

namespace App\Repository;

use App\Entity\SalidaLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalidaLog>
 *
 * @method SalidaLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalidaLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalidaLog[]    findAll()
 * @method SalidaLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalidaLogRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, SalidaLog::class);
    }

    //    /**
    //     * @return SalidaLog[] Returns an array of SalidaLog objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SalidaLog
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
