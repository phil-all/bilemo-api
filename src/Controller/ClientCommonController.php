<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Shopper;
use App\Service\Pager\Pager;
use App\Form\ShopperFormType;
use App\Repository\ShopperRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\FormErrorConvertor\FormValidationHandler as Validator;

/**
 * Manage clients entry points for versions 1 & 2
 * @package App\Controller
 */
class ClientCommonController extends AbstractController
{
    /**
     * @Route("/clients/{id}/shoppers", name="api_client_get_shoppers", methods={"GET"})
     */
    public function showAllUsers(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Shopper::class, Client::class);

        return $this->json($pager->paginate(), 200, [], []);
    }

    /**
     * @Route("/clients/{id}/shoppers/{shopper_id}", name="api_client_get_shopper", methods={"GET"})
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     */
    public function showOneUser(Shopper $shopper): JsonResponse
    {
        return $this->json($shopper, 200, [], ['groups' => 'user:get-one']);
    }

    /**
     * @Route("/clients/{id}/shoppers", name="api_client_post_shopper", methods={"POST"})
     */
    public function new(Request $request, Client $client, ShopperRepository $repo, Validator $validator): JsonResponse
    {
        $data    = json_decode($request->getContent(), true);
        $shopper = new Shopper();
        $form    = $this->createForm(ShopperFormType::class, $shopper)->submit($data);

        if (!$form->isValid()) {
            return $validator->unvalidate($form);
        }

        $shopper = $repo->finalize($client, $shopper);

        return $this->json($shopper, 201, [], ['groups' => 'user:get-one']);
    }

    /**
     * @Route("/clients/{id}/shoppers/{shopper_id}", name="api_client_delete_shopper", methods={"DELETE"})
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     */
    public function remove(Shopper $shopper, ShopperRepository $repo): JsonResponse
    {
        $repo->remove($shopper);

        return $this->json(null, 204, [], []);
    }
}
