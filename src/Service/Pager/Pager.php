<?php

namespace App\Service\Pager;

use Symfony\Component\HttpFoundation\Request;
use App\Service\Pager\Repository\RepositoryHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Pager, a generic pagination service.
 * @package App\Service\Pager
 */
class Pager
{
    /**
     * @var string
     */
    private string $main;

    /**
     * @var integer
     */
    private int $limit;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;

    /**
     * @var RepositoryHandler
     */
    private RepositoryHandler $repository;

    /**
     * @var integer|null
     */
    private ?int $secondaryId = null;

    /**
     * Pager constructor
     *
     * @param UrlGeneratorInterface $router
     * @param RepositoryHandler     $repo
     */
    public function __construct(UrlGeneratorInterface $router, RepositoryHandler $repo)
    {
        $this->router     = $router;
        $this->repository = $repo;
    }

    /**
     * Initialize pager service
     *
     * @param Request     $request
     * @param integer     $limit
     * @param string      $main main entity required (eg EntityName::class)
     * @param string|null $secondary optionnal: entity managing the main entity
     *
     * @return void
     */
    public function init(Request $request, int $limit, string $main, ?string $secondary = null): void
    {
        $this->request = $request;
        $this->limit   = $limit;
        $this->main    = $main;

        $this->setSecondary($request, $secondary);

        $this->repository->buildRepo($main, $this->getCurrentPage(), $limit, $this->secondaryId);
    }

    /**
     * Get the paginated datas
     *
     * @return array<array>
     */
    public function paginate(): array
    {
        /** @var array */
        $items = $this->getPaginatedItems();

        /** @var string $className */
        $className = strtolower((new \ReflectionClass($this->main))->getShortName());

        foreach ($items as &$item) {
            $url = $this->router->generate(
                $this->request->attributes->get('_route'),
                [
                    'id' => $item['id']
                ],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $item = array_merge($item, ['Link' => $url . '/' . $item['id']]);
        }

        return [
            'pagination' => [
                'pages'    => $this->getPageCount(),
                'fisrt'    => $this->getFirst(),
                'previous' => $this->getPrevious(),
                'self'     => $this->getCurrentPage(),
                'next'     => $this->getNext(),
                'last'     => $this->getLast()
            ],
            $className . 's' => $items
        ];
    }

    /**
     * Set parameters if secondary entity exists
     *
     * @param Request $request
     * @param string  $secondary
     *
     * @return void
     */
    private function setSecondary(Request $request, ?string $secondary): void
    {
        if (null !== $secondary) {
            $this->secondaryId = $request->attributes->get('id');
        }
    }

    /**
     * Get paginated items
     *
     * @return array<object>
     */
    private function getPaginatedItems(): array
    {
        return (null === $this->secondaryId)
            ? $this->repository->selectOnSingleTalbe()
            : $this->repository->selectOnJoinedTables();
    }

    /**
     * Get pages count
     *
     * @return integer
     */
    private function getPageCount(): int
    {
        $count = (null === $this->secondaryId)
            ? $this->repository->countSingleTable()
            : $this->repository->countJoinedTables();

        return (int)ceil($count / $this->limit);
    }

    /**
     * Get the previous page url if exists
     *
     * @return string|null
     */
    private function getPrevious(): ?string
    {
        return ($this->getCurrentPage() === 1) ? null : $this->getPageUrl($this->getCurrentPage() - 1);
    }

    /**
     * Get the next page url if exists
     *
     * @return string|null
     */
    private function getNext(): ?string
    {
        return ($this->getCurrentPage() < $this->getPageCount())
            ? $this->getPageUrl($this->getCurrentPage() + 1)
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
     * Get a page url
     *
     * @param integer $page
     *
     * @return string
     */
    private function getPageUrl(int $page): string
    {
        return $this->router->generate(
            $this->getCurrentRoute(),
            [
                'page' => $page,
                'id'   => $this->secondaryId
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    private function getCurrentRoute(): string
    {
        return $this->request->attributes->get('_route');
    }

    private function getCurrentPage(): int
    {
        return (int)$this->request->query->get('page', 1);
    }
}
