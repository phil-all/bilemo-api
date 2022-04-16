<?php

namespace App\Swagger;

/**
 * Class for swagger documention use only,
 * It represent model options list (many to many relation)
 *
 * @OA\Schema()
 */
class Options
{
    /**
     * @var array<string>
     *
     * @OA\Property(
     *      type="array",
     *      example={{"option": "double optique arrière"}, {"option": "connectivité 5G"},{"option": "touch ID"}},
     *           @OA\Items(
     *              @OA\Property(
     *                  property="option",
     *                  type="string"
     *              )
     *           )
     * )
     */
    protected array $options;
}
