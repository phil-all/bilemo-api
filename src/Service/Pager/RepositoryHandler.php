<?php

namespace App\Service\Pager;

use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * RepositoryHandler for Pager
 * @package App\Service\Pager
 */
class RepositoryHandler
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $manager;

    /**
     * @var integer
     */
    private int $currentPage;

    /**
     * @var integer
     */
    private int $limit;

    /**
     * @var integer|null
     */
    private ?int $secondaryId;

    /**
     * Pager constructor
     *
     * @param ManagerRegistry $manager
     */
    public function __construct(ManagerRegistry $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @var EntityRepository
     */
    private EntityRepository $repository;

    /**
     * Get Repository and set properties
     *
     * @param string       $mainEntity
     * @param integer      $currentPage
     * @param integer      $limit
     * @param integer|null $secondaryEntityId
     *
     * @return self
     */
    public function buildRepo(string $mainEntity, int $currentPage, int $limit, ?int $secondaryEntityId): self
    {
        $this->repository  = $this->getRepository($mainEntity);
        $this->currentPage = $currentPage;
        $this->limit       = $limit;
        $this->secondaryId = $secondaryEntityId;

        return $this;
    }

    /**
     * Get repository from entity name
     *
     * @param string $entity
     * @psalm-param class-string<T> $entity
     *
     * @return EntityRepository
     * @template T of object
     */
    public function getRepository(string $entity): EntityRepository
    {
        return $this->manager->getRepository($entity);
    }

    /**
     * get main table count
     *
     * @return integer
     */
    public function countSingleTable(): int
    {
        return $this->repository
            ->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * get count on joined table
     *
     * @return integer
     */
    public function countJoinedTables(): int
    {
        return $this->repository
            ->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->join('m.client', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $this->secondaryId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get query on single table result
     *
     * @return array
     */
    public function selectOnSingleTalbe(): array
    {
        return $this->repository
            ->createQueryBuilder('m')
            ->setFirstResult(($this->currentPage * $this->limit) - $this->limit)
            ->setMaxResults($this->limit)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Get query with inner join result
     *
     * @return array
     */
    public function selectOnJoinedTables(): array
    {
        return $this->repository
            ->createQueryBuilder('s')
            ->select('s.id, s.email')
            ->join('s.client', 'c')
            ->where('c.id = :client_id')
            ->setFirstResult(($this->currentPage * $this->limit) - $this->limit)
            ->setMaxResults($this->limit)
            ->setParameter('client_id', $this->secondaryId)
            ->getQuery()
            ->getArrayResult();
    }
}
