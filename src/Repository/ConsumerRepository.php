<?php

namespace App\Repository;

use App\Entity\Consumer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Consumer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consumer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consumer[]    findAll()
 * @method Consumer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consumer::class);
    }

    // /**
    //  * @return Consumer[] Returns an array of Consumer objects
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
    public function findOneBySomeField($value): ?Consumer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllConsumers() {
        $query = $this->createQueryBuilder('c')
            ->where('1 = 1')
            ->orderBy('c.created_at','DESC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findSomeConsumers(string $ip) {
        $query = $this->createQueryBuilder('c')
            ->where('c.ip_address = :ip')
            ->setParameter(':ip', $ip)
            ->orderBy('c.created_at','DESC')
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findOneConsumer($id) {
        $query = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter(':id',$id)
            ->getQuery();

        return $query->getArrayResult();
    }

    public function getLastConsumer() {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.created_at', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getArrayResult();
    }

    public function cleanConsumers() {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'TRUNCATE TABLE consumer CASCADE';
        $statement = $conn->prepare($sql);
        $statement->execute();
    }
}
