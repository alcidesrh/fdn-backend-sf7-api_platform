<?php

namespace App\Repository;

use App\Entity\Ui;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ui>
 *
 * @method Ui|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ui|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ui[]    findAll()
 * @method Ui[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ui::class);
    }

//    /**
//     * @return Ui[] Returns an array of Ui objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ui
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
