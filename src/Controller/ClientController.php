<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Shopper;
use App\Service\Pager\Pager;
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
     * @Route("/clients/{id}/shoppers", name="api_client_shoppers_list", methods={"GET"})
     */
    public function showAllUsers(Request $request, Pager $pager, Client $client): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, 'Shopper', 'Client');

        return $this->json($pager->paginate(), 200, [], []);
    }

    /**
     * @Route("/clients/{client_id}/shoppers/{shopper_id}", name="api_client_shopper", methods={"GET"})
     * @ParamConverter("client", options={"mapping": {"client_id":"id"}})
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     */
    public function showOneUser(Request $request, Pager $pager, Client $client, Shopper $shopper): JsonResponse
    {
        return $this->json($shopper, 200, [], ['groups' => 'user:get-one']);
    }
}
