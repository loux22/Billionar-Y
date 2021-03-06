<?php

namespace App\Repository;

use App\Entity\Historic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Historic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historic[]    findAll()
 * @method Historic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historic::class);
    }

    // /**
    //  * @return Historic[] Returns an array of Historic objects
    //  */
    
    public function alreadyGameToday($date, $game)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.date = :date')
            ->setParameter('date', $date)
            ->andWhere('h.game = :game')
            ->setParameter('game', $game)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function money()
    {
        return $this->createQueryBuilder('h')
            ->select("sum(h.nbParty) as nbParty, sum(h.total) as total")
            ->getQuery()
            ->getResult()
        ;
    }

    public function moneyByGame($game)
    {
        return $this->createQueryBuilder('h')
            ->select("sum(h.nbParty) as nbParty, sum(h.total) as total")
            ->andWhere('h.game = :game')
            ->setParameter('game', $game)
            ->getQuery()
            ->getResult()
        ;
    }

    public function moneyByUser()
    {
        return $this->createQueryBuilder('h')
            ->select("sum(h.nbParty) as nbParty, sum(h.total) as total")
            ->groupBy('h.user')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Historic
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
