<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function customFindByCriter($limit,$offset,$search)
    {
        return $this->createQueryBuilder('e')
            ->where('e.nom LIKE :search')
            ->orWhere('e.adress LIKE :search')
            ->orWhere('e.tel_fixe LIKE :search')
            ->orWhere('e.tel_autre LIKE :search')
            ->orWhere('e.email LIKE :search')
            ->orWhere('e.site LIKE :search')
            ->orWhere('e.speciality LIKE :search')
            ->orWhere('e.price LIKE :search')
            ->orWhere('e.description LIKE :search')
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
            ->orWhere('e.adress LIKE :search')
            ->orWhere('e.tel_fixe LIKE :search')
            ->orWhere('e.tel_autre LIKE :search')
            ->orWhere('e.email LIKE :search')
            ->orWhere('e.site LIKE :search')
            ->orWhere('e.speciality LIKE :search')
            ->orWhere('e.price LIKE :search')
            ->orWhere('e.description LIKE :search')
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
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurant
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
