<?php

namespace App\Repository;

use App\Entity\Client;
use DateTimeImmutable;
use App\Entity\Shopper;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Shopper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shopper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shopper[]    findAll()
 * @method Shopper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shopper::class);
    }

    /**
     * New shopper creation ending
     *
     * @param Client  $client
     * @param Shopper $shopper
     *
     * @return Shopper
     */
    public function finalize(Client $client, Shopper $shopper): Shopper
    {
        $shopper
            ->setClient($client)
            ->setCreatedAt(new DateTimeImmutable('now'));

        $this->add($shopper);

        return $shopper;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Shopper $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Shopper $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
