<?php

namespace App\Repository;

use App\Entity\Raise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Raise>
 *
 * @method Raise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raise[]    findAll()
 * @method Raise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Raise::class);
    }

//    /**
//     * @return Raise[] Returns an array of Raise objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Raise
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
