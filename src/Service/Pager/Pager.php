<?php

namespace App\Service\Pager;

use OpenApi\Annotations as OA;
use App\Service\Pager\Pagination;
use App\Service\Pager\PaginatedItems;
use App\Service\Pager\RepositoryHandler;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RequestInspector\RequestInspector;

/**
 * Pager, a generic pagination service.
 * @package App\Service\Pager
 */
class Pager
{
    use Helper;

    /**
     * @var RequestInspector
     */
    private RequestInspector $requestInspector;

    /**
     * @var Pagination
     */
    private Pagination $pagination;

    /**
     * @var PaginatedItems
     */
    private PaginatedItems $paginatedItems;

    /**
     * @var RepositoryHandler
     */
    private RepositoryHandler $repository;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var array<object>
     */
    protected array $items;

    /**
     * Pager constructor
     *
     * @param Pagination        $pagination
     * @param PaginatedItems    $paginatedItems
     * @param RequestInspector  $requestInspector
     * @param RepositoryHandler $repository
     */
    public function __construct(
        Pagination $pagination,
        PaginatedItems $paginatedItems,
        RequestInspector $requestInspector,
        RepositoryHandler $repository
    ) {
        $this->pagination        = $pagination;
        $this->paginatedItems    = $paginatedItems;
        $this->requestInspector  = $requestInspector;
        $this->repository        = $repository;
    }

    /**
     * Initialize pager service
     *
     * @param Request     $request
     * @param integer     $limit
     * @param string      $mainEntity
     * @param string|null $secondaryEntity
     *
     * @return void
     */
    public function init(Request $request, int $limit, string $mainEntity, ?string $secondaryEntity = null): void
    {
        $this->request = $request;

        $this->repository->buildRepo(
            $mainEntity,
            $this->getCurrentPage($this->requestInspector),
            $limit,
            $this->getSecondaryEntityId($secondaryEntity)
        );

        $this->pagination->init(
            $this->repository,
            $mainEntity,
            $limit,
            $this->getSecondaryEntityId($secondaryEntity)
        );

        $this->paginatedItems->init($this->repository, $this->getSecondaryEntityId($secondaryEntity));
    }

    /**
     * Get the pagination datas
     *
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination->getPagination();
    }

    /**
     * Get paginated items
     *
     * @return array
     */
    public function getPaginatedItems(): array
    {
        return $this->paginatedItems->getPaginatedItems();
    }

    /**
     * Set secondary entity id if exists
     *
     * @param string|null $secondaryEntity
     *
     * @return integer|null
     */
    private function getSecondaryEntityId(?string $secondaryEntity): ?int
    {
        if (null !== $secondaryEntity) {
            return $this->request->attributes->get('id');
        }

        return null;
    }
}
