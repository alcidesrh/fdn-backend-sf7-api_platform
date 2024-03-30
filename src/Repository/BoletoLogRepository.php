<?php

namespace App\Repository;

use App\Entity\BoletoLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoletoLog>
 *
 * @method BoletoLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoletoLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoletoLog[]    findAll()
 * @method BoletoLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoletoLogRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BoletoLog::class);
    }

    //    /**
    //     * @return BoletoLog[] Returns an array of BoletoLog objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BoletoLog
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
