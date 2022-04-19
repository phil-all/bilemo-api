<?php

namespace App\Service\RequestValidator;

use App\Entity\Shopper;
use App\Repository\ClientRepository;
use App\Repository\ShopperRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\JWTTokenInspector\JWTTokenInspector as JWT;
use App\Service\RequestInspector\RequestInspector as Inspector;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Used to validate request
 * @package App\Service\RequestValidator
 */
class RequestValidator
{
    /**
     * @var Inspector
     */
    private Inspector $inspector;

    /**
     * @var JWT
     */
    private JWT $jwt;

    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     * @var ShopperRepository
     */
    private ShopperRepository $shopperRepository;

    /**
     * RequestValidator constructor
     *
     * @param Inspector        $inspector
     * @param JWT              $jwt
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        Inspector $inspector,
        JWT $jwt,
        ClientRepository $clientRepository,
        ShopperRepository $shopperRepository
    ) {
        $this->inspector         = $inspector;
        $this->jwt               = $jwt;
        $this->clientRepository  = $clientRepository;
        $this->shopperRepository = $shopperRepository;
    }

    /**
     * Initialize the request in validator
     *
     * @param Request $request
     *
     * @return self
     */
    public function init(Request $request): self
    {
        $this->inspector->setRequest($request);
        $this->jwt->setRequest($request);
        return $this;
    }

    /**
     * Check if uri is a client ressources entry point
     *
     * @return boolean
     */
    public function isClientRessourcesEntryPoint(): bool
    {
        return str_contains($this->inspector->getRoute(), '_client_');
    }

    /**
     * Check if Client identified by its token is the same as mentioned in uri
     *
     * @return boolean
     */
    public function isClientSameOnUri(): bool
    {
        $idFromEmailInJwt = $this->clientRepository->getIdByEmail($this->jwt->getClaim('email'));

        return (int)$this->inspector->getParameter('id') === $idFromEmailInJwt;
    }

    /**
     * Check if authenticated client is owner of shopper in uri
     *
     * @return boolean
     */
    public function isShopperOwner(): bool
    {
        $idFromEmailInJwt = $this->clientRepository->getIdByEmail($this->jwt->getClaim('email'));

        /** @var Shopper $shopper */
        $shopper = $this->shopperRepository->find($this->inspector->getParameter('shopper_id'));

        if (!$this->shopperRepository->isShopperExist((int)$this->inspector->getParameter('shopper_id'))) {
            throw new NotFoundHttpException();
        }

        $ownerId = $shopper->getClient()->getId();

        return $idFromEmailInJwt === $ownerId;
    }

    /**
     * Verify if a querry parameter exist
     *
     * @param string $name
     *
     * @return boolean
     */
    public function isQueryParamExists(string $name): bool
    {
        return !empty($this->inspector->getQueryParameter($name));
    }
}
