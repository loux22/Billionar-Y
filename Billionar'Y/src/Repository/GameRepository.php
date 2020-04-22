<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    
    public function findNbParty()
    {
        return $this->createQueryBuilder('g')
            ->select("sum(g.nbPlay) as nbPlay")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findNbGames($isActive)
    {
        return $this->createQueryBuilder('g')
            ->select("count(g.id) as nbGames")
            ->andWhere('g.isActive = :isActive')
            ->setParameter('isActive', $isActive)
            ->getQuery()
            ->getResult()
        ;
    }

    
    

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
