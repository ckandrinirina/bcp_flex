<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function customFindByCriter($limit,$offset,$search)
    {
        return $this->createQueryBuilder('e')
            ->where('e.nom LIKE :search')
            ->orWhere('e.presentation LIKE :search')
            ->orWhere('e.place LIKE :search')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->setParameter('search','%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function customFindByCriterCount($search)
    {
        return $this->createQueryBuilder('e')
            ->where('e.nom LIKE :search')
            ->orWhere('e.presentation LIKE :search')
            ->orWhere('e.place LIKE :search')
            ->setParameter('search','%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSoundex($critere,$offset)
    {
        return $this->createQueryBuilder('e')
        ->where("SOUNDEX(e.nom) LIKE SOUNDEX(:search)")
        ->setParameter('search','%'.$critere.'%')
        ->setFirstResult( $offset )
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }

    public function findDetail($offset)
    {
        return $this->createQueryBuilder('e')
        ->orderBy('e.viewers','DESC')
        ->setFirstResult( $offset )
        ->setMaxResults(5)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
