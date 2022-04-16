<?php

namespace App\Service\Pager;

use OpenApi\Annotations as OA;
use Doctrine\ORM\EntityRepository;
use App\Service\Pager\RepositoryHandler;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RequestInspector\RequestInspector;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Pagination Builder for Pager service
 * @package App\Service\Pager
 *
 * @OA\Schema()
 */
class Pagination
{
    use Helper;

    /**
     * @var RepositoryHandler
     */
    private RepositoryHandler $repository;

    /**
     * @var UrlGeneratorInterface
     */
    private \Symfony\Component\Routing\Generator\UrlGeneratorInterface $router;

    /**
     * @var RequestInspector
     */
    private RequestInspector $requestInspector;

    /**
     * @var string
     */
    protected string $mainEntity;

    /**
     * @var integer|null
     */
    private ?int $secondaryEntityId;

    /**
     * @var integer
     */
    private int $limit;

    /**
     * @var array<int|string|null>
     *
     * @OA\Property(
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="count", type="integer", example="26"),
     *          @OA\Property(
     *              property="first",
     *              type="string",
     *              example="https://bilemo-domain.com/api/v1/.../example?page=1"
     *          ),
     *          @OA\Property(
     *              property="previous",
     *              type="string",
     *              example="https://bilemo-domain.com/api/v1/.../example?page=1"
     *          ),
     *          @OA\Property(property="self", type="integer", example=2),
     *          @OA\Property(
     *              property="next",
     *              type="string",
     *              example="https://bilemo-domain.com/api/v1/.../example?page=3"
     *          ),
     *          @OA\Property(
     *              property="last",
     *              type="string",
     *              example="https://bilemo-domain.com/api/v1/.../example?page=26"
     *          )
     *      )
     * )
     */
    private array $pagination;

    /**
     * Pagination constructor
     *
     * @param UrlGeneratorInterface $router
     * @param RequestInspector      $requestInspector
     */
    public function __construct(
        UrlGeneratorInterface $router,
        RequestInspector $requestInspector
    ) {
        $this->router           = $router;
        $this->requestInspector = $requestInspector;
    }

    /**
     * Initialize the pagination
     *
     * @param RepositoryHandler $repository
     * @param string           $mainEntity
     * @param integer|null     $limit
     * @param int|null      $secondaryEntityId
     *
     * @return void
     */
    public function init(
        RepositoryHandler $repository,
        string $mainEntity,
        ?int $limit,
        ?int $secondaryEntityId = null
    ): void {
        $this->repository      = $repository;
        $this->mainEntity      = $mainEntity;
        $this->limit           = $limit;
        $this->secondaryEntityId = $secondaryEntityId;

        if ($this->getCurrentPage($this->requestInspector) > $this->getPageCount()) {
            throw new NotFoundHttpException();
        }

        $this->setPagination();
    }

    /**
     * Get pagination count and links
     *
     * @return array<int|string|null>
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }

    /**
     * Get pages count
     *
     * @return integer
     */
    private function getPageCount(): int
    {
        $count = (null === $this->secondaryEntityId)
            ? $this->repository->countSingleTable()
            : $this->repository->countJoinedTables();

        return (int)ceil($count / $this->limit);
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
     * Get the previous page url if exists
     *
     * @return string|null
     */
    private function getPrevious(): ?string
    {
        return $this->getCurrentPage($this->requestInspector) === 1
            ? null
            : $this->getPageUrl($this->getCurrentPage($this->requestInspector) - 1);
    }

    /**
     * Get the next page url if exists
     *
     * @return string|null
     */
    private function getNext(): ?string
    {
        return ($this->getCurrentPage($this->requestInspector) < $this->getPageCount())
            ? $this->getPageUrl($this->getCurrentPage($this->requestInspector) + 1)
            : null;
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
     * Get a page url with a query page number
     *
     * @param integer $pageNumber
     *
     * @return string
     */
    private function getPageUrl(int $pageNumber): string
    {
        return $this->router->generate(
            $this->requestInspector->getRoute(),
            [
                'page' => $pageNumber,
                'id'   => $this->secondaryEntityId
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * Set the pagination links and count
     *
     * @return void
     */
    public function setPagination(): void
    {
        $this->pagination = array(
            'count'    => $this->getPageCount(),
            'fisrt'    => $this->getFirst(),
            'previous' => $this->getPrevious(),
            'self'     => $this->getCurrentPage($this->requestInspector),
            'next'     => $this->getNext(),
            'last'     => $this->getLast()
        );
    }
}
