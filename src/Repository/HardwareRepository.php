<?php

namespace App\Repository;

use App\Entity\Hardware;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template TEntityClass of object
 * @extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository<TEntityClass>
 *
 * @method Hardware|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hardware|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hardware[]    findAll()
 * @method Hardware[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardwareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hardware::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Hardware $entity, bool $flush = true): void
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
    public function remove(Hardware $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
