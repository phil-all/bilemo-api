<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Pager\Pager;
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
     * @param Request $request
     * @param Pager   $pager
     *
     * @return JsonResponse
     */
    public function showAll(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Product::class);

        return $this->json($pager->paginate(), 200, [], ['groups' => 'product:get-all']);
    }

    /**
     * @Route("/v1/products/{id}", name="api_v1_get_product")
     * @Route("/v2/products/{id}", name="api_v2_get_product")
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
