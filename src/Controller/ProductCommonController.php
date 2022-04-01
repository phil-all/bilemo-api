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
 * @Route("/api/v1")
 * @Route("/api/v2")
 */
class ProductCommonController extends AbstractController
{
    /**
     * @Route("/products", name="api_get_products", methods={"GET"})
     */
    public function showAll(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Product::class);

        return $this->json($pager->paginate(), 200, [], ['groups' => 'product:get-all']);
    }

    /**
     * @Route("/products/{id}", name="api_get_product")
     */
    public function showOne(Product $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => 'product:get-one']);
    }
}
