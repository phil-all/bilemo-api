<?php

namespace App\Service\Pager;

use App\Service\Pager\RepositoryHandler;
use App\Service\RequestInspector\RequestInspector;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Paginated items list for Pager service
 * @package App\Service\Pager
 */
class PaginatedItems
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;

    /**
     * @var RequestInspector
     */
    private RequestInspector $requestInspector;

    /**
     * @var RepositoryHandler
     */
    private RepositoryHandler $repository;

    /**
     * @var integer|null
     */
    private ?int $secondaryEntityId;

    /**
     * @var array<object>
     */
    private array $items;

    /**
     * PaginatedItems constructor
     *
     * @param UrlGeneratorInterface $router
     * @param RequestInspector      $requestInspector
     */
    public function __construct(UrlGeneratorInterface $router, RequestInspector $requestInspector)
    {
        $this->router            = $router;
        $this->requestInspector  = $requestInspector;
    }

    /**
     * Initialize the paginated items
     *
     * @param RepositoryHandler $repository
     * @param integer|null      $secondaryEnityId
     *
     * @return void
     */
    public function init(RepositoryHandler $repository, ?int $secondaryEnityId = null): void
    {
        $this->repository        = $repository;
        $this->secondaryEntityId = $secondaryEnityId;

        $this->setPaginatedItems();
    }
    /**
     * Get paginated items
     *
     * @return array<object>
     */
    public function getPaginatedItems(): array
    {
        return $this->items;
    }

    /**
     * Set paginated items
     *
     * @return void
     */
    public function setPaginatedItems(): void
    {
        $items = (null === $this->secondaryEntityId)
            ? $this->repository->selectOnSingleTalbe()
            : $this->repository->selectOnJoinedTables();

        foreach ($items as $item) {
            $url = $this->router->generate(
                $this->requestInspector->getRoute(),
                array('id' => $item['id']),
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $item = array_merge($item, array('Link' => $url . '/' . $item['id']));
        }

        $this->items = $items;
    }
}
