<?php

namespace App\Repository;

use App\Entity\RankingWinning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RankingWinning|null find($id, $lockMode = null, $lockVersion = null)
 * @method RankingWinning|null findOneBy(array $criteria, array $orderBy = null)
 * @method RankingWinning[]    findAll()
 * @method RankingWinning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RankingWinningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RankingWinning::class);
    }

    // /**
    //  * @return RankingWinning[] Returns an array of RankingWinning objects
    //  */
    
    public function findRankingEarnings()
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.winning', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    public function HistoricRankingEarnings($game)
    {
        return $this->createQueryBuilder('w')
            -> where('w.id_game = :game')
            -> setParameter('game', $game)
            ->orderBy('w.winning', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?RankingWinning
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
