<?php

namespace App\Repository;

use App\Entity\Mouvies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Mouvies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mouvies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mouvies[]    findAll()
 * @method Mouvies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MouviesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mouvies::class);
    }

    // /**
    //  * @return Mouvies[] Returns an array of Mouvies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

/*
    public function findOneBySomeField($value): ?Mouvies
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
*/
//selectonner tous les film triés par date de 'release_date'
        public function getListMouvie($page=1, $maxperpage)
        {
            $query = $this->createQueryBuilder('m')
                ->select('m')
                ->orderBy('m.release_date', 'DESC')
                ;
            $query->setFirstResult(($page-1) * $maxperpage)
                ->setMaxResults($maxperpage);
            return new Paginator($query);
        }

        //nombre de mouvies dans la requete
        public function countTotal()
        {
         $query = $this->createQueryBuilder('m')
                ->select('COUNT(m)')
                ;
            return $count = $query->getQuery()->getSingleScalarResult();
        }
    
}
