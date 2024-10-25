<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
        public function findAuthorByUsername(string $username)
        {
            return $this->createQueryBuilder('a')
                //->select('a.username')
                ->andWhere('a.username LIKE :username')
                ->andWhere("a.email = :email ")
                ->setParameter('username', '%'.$username.'%')
                ->setParameter('email', 'abc@gmail.com')
               // ->orderBy('a.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }
        public function findAuthorByUsernameDQL(string $username){
            return $this->getEntityManager()
            ->createQuery('SELECT count(a) FROM App\Entity\Author a WHERE a.username = ?1 ORDER BY a.id DESC')
            ->setParameter('1', $username)
            ->getSingleScalarResult();
        }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
