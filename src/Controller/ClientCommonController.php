<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Shopper;
use App\Service\Pager\Pager;
use App\Form\ShopperFormType;
use OpenApi\Annotations as OA;
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
 *
 * @Route("/api")
 */
class ClientCommonController extends AbstractController
{
    /**
     * @Route("/v1/clients/{id<\d+>}/shoppers", name="api_v1_client_get_shoppers", methods={"GET"})
     * @Route("/v2/clients/{id<\d+>}/shoppers", name="api_v2_client_get_shoppers", methods={"GET"})
     *
     * @OA\Get(
     *      path="/api/v1/clients/{client_id}/shoppers",
     *      operationId="showAllShoppers",
     *      tags={"Clients v1"},
     *      summary="Get shoppers list for a given client",
     *      security={"bearerAuth":{}},
     *      @OA\Parameter(
     *          in="header",
     *          name="Authorization",
     *          required= true,
     *          description="Bearer JWT Token",
     *          @OA\Schema(type="bearerAuth"),
     *     ),
     *      @OA\Parameter(
     *          in="path",
     *          name="client_id",
     *          required=true,
     *          description="Client id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/Pagination"),
     *                      @OA\Schema(ref="#/components/schemas/PaginatedShoppers")
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Token invalid or expire",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Bad Request: Your token is invalid."
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Token is missing, please login to get one."
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Forbiden access",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Ressoureces requested are not your own."
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Server error",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Internal server error."
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @param Pager   $pager
     *
     * @return JsonResponse
     */
    public function showAllShoppers(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Shopper::class, Client::class);

        $datas = [
            'pagination' => $pager->getPagination(),
            'shoppers'   => $pager->getPaginatedItems()
        ];

        return $this->json($datas, 200, [], ['groups' => 'shopper:get-all']);
    }

    /**
     * @Route("/v1/clients/{id<\d+>}/shoppers/{shopper_id<\d+>}", name="api_v1_client_get_shopper", methods={"GET"})
     * @Route("/v2/clients/{id<\d+>}/shoppers/{shopper_id<\d+>}", name="api_v2_client_get_shopper", methods={"GET"})
     *
     * @OA\Get(
     *      path="/api/v1/clients/{client_id}/shoppers/{shopper_id}",
     *      operationId="showOneShopper",
     *      tags={"Clients v1"},
     *      summary="Get one shopper from a given client",
     *      security={"bearerAuth":{}},
     *      @OA\Parameter(
     *          in="header",
     *          name="Authorization",
     *          required= true,
     *          description="Bearer JWT Token",
     *          @OA\Schema(type="bearerAuth"),
     *      ),
     *      @OA\Parameter(
     *          in="path",
     *          name="client_id",
     *          required=true,
     *          description="Client id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          in="path",
     *          name="shopper_id",
     *          required=true,
     *          description="Shopper id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Shopper")
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Token invalid or expire",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Bad Request: Your token is invalid."
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Token is missing, please login to get one."
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Forbiden access",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Ressoureces requested are not your own."
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Required ressource not found."
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Server error",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Internal server error."
     *          )
     *      )
     * )
     *
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     *
     * @param Shopper $shopper
     *
     * @return JsonResponse
     */
    public function showOneShopper(Shopper $shopper): JsonResponse
    {
        return $this->json($shopper, 200, [], ['groups' => 'get-one']);
    }

    /**
     * @Route("/v1/clients/{id<\d+>}/shoppers", name="api_v1_client_post_shopper", methods={"POST"})
     * @Route("/v2/clients/{id<\d+>}/shoppers", name="api_v2_client_post_shopper", methods={"POST"})
     *
     * @OA\Post(
     *      path="/api/v1/clients/{client_id}/shoppers",
     *      operationId="postNewShopper",
     *      tags={"Clients v1"},
     *      summary="Create a new shopper from a client",
     *      security={"bearerAuth":{}},
     *      @OA\Parameter(
     *          in="header",
     *          name="Authorization",
     *          required= true,
     *          description="Bearer JWT Token",
     *          @OA\Schema(type="bearerAuth"),
     *      ),
     *      @OA\Parameter(
     *          in="path",
     *          name="client_id",
     *          required=true,
     *          description="Client id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="client credentials",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  description="Client id",
     *                  example=564),
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="Client email",
     *                  example="john.doe@gmaiol.com"),
     *              @OA\Property(
     *                  property="firstName",
     *                  type="string",
     *                  description="Client password",
     *                  example="John"
     *              ),
     *              @OA\Property(
     *                  property="lastName",
     *                  type="string",
     *                  description="Client password",
     *                  example="Doe"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Shopper")
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Token invalid or expire",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Bad Request: Your token is invalid."
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Token is missing, please login to get one."
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Forbiden access",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Ressoureces requested are not your own."
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Server error",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Internal server error."
     *          )
     *      )
     * )
     *
     * @param Request           $request
     * @param Client            $client
     * @param ShopperRepository $repo
     * @param Validator         $validator
     *
     * @return JsonResponse
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

        return $this->json($shopper, 201, [], ['groups' => 'get-one']);
    }

    /**
     * @Route(
     *      "/v1/clients/{id<\d+>}/shoppers/{shopper_id<\d+>}",
     *      name="api_v1_client_delete_shopper",
     *      methods={"DELETE"}
     * )
     * @Route(
     *      "/v2/clients/{id<\d+>}/shoppers/{shopper_id<\d+>}",
     *      name="api_v2_client_delete_shopper",
     *      methods={"DELETE"}
     * )
     *
     * @OA\Delete(
     *      path="/api/v1/clients/{client_id}/shoppers/{shopper_id}",
     *      operationId="remove",
     *      tags={"Clients v1"},
     *      summary="Delete a shopper from a given client",
     *      security={"bearerAuth":{}},
     *      @OA\Parameter(
     *          in="header",
     *          name="Authorization",
     *          required= true,
     *          description="Bearer JWT Token",
     *          @OA\Schema(type="bearerAuth"),
     *      ),
     *      @OA\Parameter(
     *          in="path",
     *          name="client_id",
     *          required=true,
     *          description="Client id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          in="path",
     *          name="shopper_id",
     *          required=true,
     *          description="Shopper id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="204",
     *          description="No Content"
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Token invalid or expire",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Bad Request: Your token is invalid."
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Token is missing, please login to get one."
     *          )
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Forbiden access",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Ressoureces requested are not your own."
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Required ressource not found."
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Server error",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Internal server error."
     *          )
     *      )
     * )
     *
     * @ParamConverter("shopper", options={"mapping": {"shopper_id":"id"}})
     *
     * @param Shopper           $shopper
     * @param ShopperRepository $repo
     *
     * @return JsonResponse
     */
    public function remove(Shopper $shopper, ShopperRepository $repo): JsonResponse
    {
        $repo->remove($shopper);

        return $this->json(null, 204, [], []);
    }
}
