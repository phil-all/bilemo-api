<?php

namespace App\Controller;

use App\Service\Pager;
use App\Entity\Product;
use App\Repository\ProductRepository;
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
    public function showAll(Request $request, ProductRepository $repo, Pager $pager): JsonResponse
    {
        $currentRoute = $request->attributes->get('_route');
        $currentPage  = (int)$request->query->get('page', 1);
        $limit        = 7;

        $pager->init($repo, $currentPage, $currentRoute, $limit);

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
