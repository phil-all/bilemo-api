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
class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="api_products_list", methods={"GET"})
     */
    public function showAll(Request $request, Pager $pager): JsonResponse
    {
        $limit = 7;

        $pager->init($request, $limit, Product::class);

        return $this->json($pager->paginate(), 200, [], ['groups' => 'product:get-all']);
    }

    /**
     * @Route("/products/{id}", name="api_products_single")
     */
    public function showOne(Product $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => 'product:get-one']);
    }
}
