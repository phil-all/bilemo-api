<?php

namespace App\Service;

use Doctrine\ORM\EntityRepository;
use PhpParser\Node\Expr\Cast\Object_;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Paginate, used to manage pagination
 * @package  App\Service
 */
class Pager
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repo;

    /**
     * @var integer
     */
    private int $limit;

    /**
     * @var string
     */
    private string $currentRoute;

    /**
     * @var integer
     */
    private int $currentPage;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Pager constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Initialize the pager
     *
     * @param EntityRepository $repo
     * @param integer          $currentPage
     * @param integer          $limit
     *
     * @return void
     */
    public function init(EntityRepository $repo, int $currentPage, string $route, int $limit = 10): void
    {
        $this->repo         = $repo;
        $this->limit        = $limit;
        $this->currentRoute = $route;
        $this->currentPage  = $currentPage;
    }

    /**
     * Get the paginated datas
     *
     * @return array<array>
     */
    public function paginate(): array
    {
        return [
            'pagination' => [
                'total'    => $this->getPageCount(),
                'fisrt'    => $this->getFirst(),
                'previous' => $this->getPrevious(),
                'self'     => $this->getCurrent(),
                'next'     => $this->getNext(),
                'last'     => $this->getLast()
            ],
            'products' => $this->getPaginatedItems()
        ];
    }

    /**
     * Get paginated items
     *
     * @return array<object>
     */
    public function getPaginatedItems(): array
    {
        return $this->repo
            ->createQueryBuilder('i')
            ->setFirstResult(($this->currentPage * $this->limit) - $this->limit)
            ->setMaxResults($this->limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get pages count
     *
     * @return integer
     */
    private function getPageCount(): int
    {
        return (int)ceil($this->getItemCount() / $this->limit);
    }

    private function getCurrent(): string
    {
        return $this->getPageUrl($this->currentPage);
    }

    /**
     * Get the previous page url if exists
     *
     * @return string|null
     */
    private function getPrevious(): ?string
    {
        return ($this->currentPage === 1)
            ? null
            : $this->getPageUrl($this->currentPage - 1);
    }

    /**
     * Get the next page url if exists
     *
     * @return string|null
     */
    private function getNext(): ?string
    {
        return ($this->currentPage < $this->getPageCount())
            ? $this->getPageUrl($this->currentPage + 1)
            : null;
    }

    /**
     * Get the first page url
     *
     * @return string
     */
    private function getFirst(): string
    {
        return $this->getPageUrl(1);
    }

    /**
     * Get the last page url
     *
     * @return string
     */
    private function getLast(): string
    {
        return $this->getPageUrl($this->getPageCount());
    }

    /**
     * Get items counts
     *
     * @return integer
     */
    private function getItemCount(): int
    {
        return $this->repo
            ->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get a page url
     *
     * @param integer $page
     *
     * @return string
     */
    private function getPageUrl(int $page): string
    {
        return $this->container->get('router')->generate(
            $this->currentRoute,
            array('page' => $page),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
