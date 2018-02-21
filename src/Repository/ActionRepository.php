<?php

namespace App\Repository;

use App\Entity\Action;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ActionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Action::class);
    }


    private function count_action(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*) FROM action
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();


    }

    public function rand_action(){

        $nombre = $this->count_action();
        $alea = rand(1,$nombre["COUNT(*)"]);
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT action FROM action WHERE id = :id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $alea]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();




    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
