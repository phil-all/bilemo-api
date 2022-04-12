<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * Class for swagger documention use only,
 * It represent shopper use of PaginatedItms from Pager service
 *
 * @OA\Schema()
 */
class PaginatedProducts
{
    /**
     * @var array<object>
     *
     * @OA\Property(
     *      type="array",
     *      example={
     *{"id": 1, "ean13": "1858712497644", "stock": 3510},
     *{"id": 2, "ean13": "3419465021012", "stock": 7082},
     *{"id": 3, "ean13": "9608795894784", "stock": 1891},
     *{"id": 4, "ean13": "5865688046901", "stock": 7076},
     *{"id": 5, "ean13": "0440710192709", "stock": 344},
     *{"id": 6, "ean13": "7061485365704", "stock": 6556},
     *{"id": 7, "ean13": "1088440691582", "stock": 2821}
     *      },
     *      @OA\Items(ref="#/components/schemas/Product")
     * )
     */
    protected array $products;
}
