<?php

namespace App\Repository;

use App\Entity\CreditorLoan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CreditorLoan|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditorLoan|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditorLoan[]    findAll()
 * @method CreditorLoan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditorLoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditorLoan::class);
    }

    // /**
    //  * @return CreditorLoan[] Returns an array of CreditorLoan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CreditorLoan
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
