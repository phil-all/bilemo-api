<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Pager\Pager;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Manage roducts entry points
 * @package App\Controller
 *
 * @Route("/api")
 */
class ProductCommonController extends AbstractController
{
    /**
     * @Route("/v1/products", name="api_v1_get_products", methods={"GET"})
     * @Route("/v2/products", name="api_v2_get_products", methods={"GET"})
     *
     * @OA\Get(
     *      path="/api/v1/products",
     *      operationId="showAllProducts",
     *      tags={"Products v1"},
     *      summary="Get products",
     *      security={"bearerAuth":{}},
     *      @OA\Parameter(
     *          in="header",
     *          name="Authorization",
     *          required= true,
     *          description="Bearer JWT Token",
     *          @OA\Schema(type="bearerAuth"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/Pagination"),
     *                      @OA\Schema(ref="#/components/schemas/PaginatedProducts")
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
    public function showAll(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Product::class);

        $datas = [
            'pagination' => $pager->getPagination(),
            'products'   => $pager->getPaginatedItems()
        ];

        return $this->json($datas, 200, [], ['groups' => 'product:get-all']);
    }

    /**
     * @Route("/v1/products/{id}", name="api_v1_get_product")
     * @Route("/v2/products/{id}", name="api_v2_get_product")
     *
     * @OA\Get(
     *      path="/api/v1/products/{product_id}",
     *      operationId="showOneProduct",
     *      tags={"Products v1"},
     *      summary="Get product detail",
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
     *          name="product_id",
     *          required=true,
     *          description="Product id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/Product"),
     *                      @OA\Schema(ref="#/components/schemas/Options")
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
     *
     *
     * @param Product $product
     *
     * @return JsonResponse
     */
    public function showOne(Product $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => 'product:get-one']);
    }
}
