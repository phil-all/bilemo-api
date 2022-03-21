<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Shopper;
use App\Service\Pager\Pager;
use App\Repository\ShopperRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Manage clients entry points
 * @package App\Controller
 *
 * @Route("/api")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/clients/{id}/shoppers", name="api_client_get_shoppers", methods={"GET"})
     */
    public function showAllUsers(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, 'Shopper', 'Client');

        return $this->json($pager->paginate(), 200, [], []);
    }

    /**
     * @Route("/clients/{serial}/shoppers/{id}", name="api_client_get_shopper", methods={"GET"})
     */
    public function showOneUser(Shopper $shopper): JsonResponse
    {
        return $this->json($shopper, 200, [], ['groups' => 'user:get-one']);
    }

    /**
     * @Route("/clients/{id}/shoppers", name="api_client_post_shopper", methods={"POST"})
     */
    public function new(Request $request, Client $client, ShopperRepository $repo): JsonResponse
    {
        $shopper = $repo->new($request, $client);

        return $this->json($shopper, 201, [], ['groups' => 'user:get-one']);
    }

    /**
     * @Route("/clients/{client_id}/shoppers/{shopper_id}", name="api_client_delete_shopper", methods={"DELETE"})
     * @ParamConverter("client", options={"mapping": {"client_id":"id"}})
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     */
    public function remove(Shopper $shopper, ShopperRepository $repo): JsonResponse
    {
        $repo->remove($shopper);

        return $this->json(null, 204, [], []);
    }
}
