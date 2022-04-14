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
     *          {"id": 1, "email": "john.doe@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/1"},
     *          {"id": 2, "email": "jane.arrow@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/2"},
     *          {"id": 3, "email": "mimi.che@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/3"},
     *          {"id": 4, "email": "bernard.chant@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/4"},
     *          {"id": 5, "email": "bibi.isworkin@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/5"},
     *          {"id": 6, "email": "bonneannee@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/6"},
     *          {"id": 7, "email": "under.nier@gmail.com", "link": "https://bilemo.com/api/v1/clients/1/shoppers/7"}
     *      },
     *      @OA\Items(ref="#/components/schemas/Shopper")
     * )
     */
    protected array $shoppers;
}
