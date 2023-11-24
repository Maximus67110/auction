<?php

namespace App\Repository;

use App\Entity\Auction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auction>
 *
 * @method Auction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auction[]    findAll()
 * @method Auction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);
    }

    public function search($title, $min, $max): array
    {
        $qb = $this->createQueryBuilder('a');

        if (!empty($title)) {
            $qb
                ->join('a.translations', 't')
                ->andWhere('t.title LIKE :title')
                ->setParameter('title', "%$title%")
            ;
        }

        if (isset($min)) {
            $qb
                ->orWhere('a.price >= :min')
                ->setParameter('min', $min * 100)
            ;
        }

        if (isset($max)) {
            $qb
                ->orWhere('a.price <= :max')
                ->setParameter('max', $max * 100)
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?Auction
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
