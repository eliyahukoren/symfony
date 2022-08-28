<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function add(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Author $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBooksByAuthor(int $author_id)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $sql = 'SELECT ba.book_id, b.title
                    FROM author a
                    LEFT JOIN book_author ba ON a.id=ba.author_id
                    LEFT JOIN book b ON b.id=ba.book_id
                WHERE a.id = ?
                ORDER BY book_id
        ';
        $rsm->addScalarResult('book_id', 'book_id');
        $rsm->addScalarResult('title', 'title');

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $author_id);
        $books = $query->getScalarResult();

        return $books;
    }

    public function findAuthorByAnyField(string $value)
    {
        $query =  $this->createQueryBuilder('a')
            ->where("a.first_name LIKE '%{$value}%'")
            ->orWhere("a.last_name LIKE '%{$value}%'")
            ->orWhere("a.notes LIKE '%{$value}%'")
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery();

        return $query->getResult();

    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

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
