<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * Class for swagger documention use only,
 * It represent product use PaginatedItems from Pager service
 *
 * @OA\Schema()
 */
class PaginatedShoppers
{
    /**
     * @var array<object>
     *
     * @OA\Property(
     *      type="array",
     *      example={
     *          {"id": 1, "email": "john.doe@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 2, "email": "jane.arrow@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 3, "email": "mimi.che@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 4, "email": "bernard.chante@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 5, "email": "bibi.isworking@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 6, "email": "bonneannee@gmail.com", "link": "a link to the shopper details"},
     *          {"id": 7, "email": "under.nier@gmail.com", "link": "a link to the shopper details"}
     *      },
     *      @OA\Items(ref="#/components/schemas/Shopper")
     * )
     */
    protected array $shoppers;
}
