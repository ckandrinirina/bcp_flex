<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    public function customFindByCriter($limit,$offset,$search)
    {
        return $this->createQueryBuilder('r')
            ->where('r.nom LIKE :search')
            ->setFirstResult( $offset )
            ->setMaxResults($limit)
            ->setParameter('search','%'.$search.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function customFindByCriterCount($search)
    {
        return $this->createQueryBuilder('r')
            ->where('r.nom LIKE :search')
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
    // /**
    //  * @return Recette[] Returns an array of Recette objects
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
    public function findOneBySomeField($value): ?Recette
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
