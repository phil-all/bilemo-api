<?php

namespace App\Controller\v1;

use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Manage authentication
 * @package App\Controller\v1
 *
 * @Route("/api/v1")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="api_v1_login", methods={"POST"})
     *
     * @OA\Post(
     *      path="/api/v1/login",
     *      operationId="index",
     *      tags={"Authentication v1"},
     *      summary="Authentication with email and pasword",
     *      @OA\RequestBody(
     *          required=true,
     *          description="client credentials",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  description="Client email",
     *                  example="user.test.bilemo@gmail.com"),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="Client password",
     *                  example="pass1234"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Authentication successfull, get a JSON object with token",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="token",
     *                      type="string",
     *                      description="JWT Token",
     *                      example="ezg54zegz48eQZREg6z4.aareg8ra6g4a6gQR4a68g4a6g8r.arQRGg46a874gar87g6arg76a7grza7g"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="401",
     *          description="Bad credentials",
     *          @OA\JsonContent(
     *              type="string",
     *              example="Bad credentials, please verify that your username or password are correctly set"
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
     */
    public function index(Request $request): Response
    {
        if (null !== $request->request->get('email') || null !== $request->request->get('password')) {
            // authentication managed directly by JWTAuthentication bundle suscriber
        }

        $message = [
            'error' => 'The keys email and password must be provided.'
        ];

        return $this->json($message, 400, [], []);
    }
}
