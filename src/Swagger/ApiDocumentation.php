<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *      title="Bilemo catalog",
 *      version="1.0.0",
 *      description="API provinding restrited access to the Bilemo catalog to authenticated clients."
 * )
 * @OA\Server(
 *      url="127.0.0.1:8100",
 *      description="Dockeriezd localhost"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="Authorization",
 *      type="http",
 *      scheme="Bearer",
 *      bearerFormat="JWT",
 * )
 */
class ApiDocumentation
{
    // empty class, OpenApi documentaion use only.
}
