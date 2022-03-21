<?php

namespace App\Repository;

use App\Entity\Client;
use DateTimeImmutable;
use App\Entity\Shopper;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Shopper|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shopper|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shopper[]    findAll()
 * @method Shopper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopperRepository extends ServiceEntityRepository
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(ManagerRegistry $registry, SerializerInterface $serializer)
    {
        parent::__construct($registry, Shopper::class);

        $this->serializer = $serializer;
    }

    /**
     * Create a new shopper
     *
     * @param Request $request
     * @param Client  $client
     *
     * @return Shopper
     */
    public function new(Request $request, Client $client): Shopper
    {
        $shopper = ($this->serializer->deserialize($request->getContent(), Shopper::class, 'json'))
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
