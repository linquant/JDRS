<?php

namespace App\Repository;

use App\Entity\Sujet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SujetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sujet::class);
    }


    private function count_sujet(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*) FROM sujet
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();


    }

    public function rand_sujet(){

        $nombre = $this->count_sujet();
        $alea = rand(1,$nombre["COUNT(*)"]);
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT sujet FROM sujet WHERE id = :id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $alea]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();




    }


    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
