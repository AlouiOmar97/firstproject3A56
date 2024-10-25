<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
        public function findBookAuthor()
        {
            return $this->createQueryBuilder('b')
                ->join('b.author', 'a')
                ->addSelect('a')
                ->where("a.email = 'william.shakespeare@gmail.com' ")
                ->getQuery()
                ->getDQL()
            ;
        }


        public function findBookAuthorDQL()
        {
            return $this->getEntityManager()
                ->createQuery("SELECT b, a FROM App\Entity\Book b INNER JOIN b.author a WHERE a.email = 'william.shakespeare@gmail.com'")
                ->getResult()
            ;
        }
    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
