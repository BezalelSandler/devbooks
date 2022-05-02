<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //  * @return Book[] Returns an array of Book objects with Authors array
    //  */
    public function getBooksWithAuthors($more_than=0){
        // RAW sql query
        $conn = $this->getEntityManager()->getConnection(); 
        $books = $this->findAll();
        foreach($books as $key=>$book) {
            $sql = "SELECT a.id, a.name  FROM author a 
                INNER JOIN book_author ba ON ba.author_id = a.id  
                INNER JOIN book b ON ba.book_id = b.id 
                WHERE b.id = '{$book->getId()}'
                    AND (SELECT count(author_id) 
                		FROM book_author WHERE book_id = b.id) > $more_than;";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $authors = $stmt->fetchAll();
            if ($authors) {
                $books[$key]->authors = $authors;
            } else {
                unset($books[$key]);
            }
        }
        return $books;
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
