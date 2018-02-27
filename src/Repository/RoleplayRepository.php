<?php

namespace App\Repository;

use App\Entity\Roleplay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RoleplayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Roleplay::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('r')
            ->where('r.something = :value')->setParameter('value', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function list_roleplay(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM roleplay
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    public function list_roleplay_by_userId($user_id){



        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM roleplay WHERE user_id = :id_user
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id_user' => $user_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
