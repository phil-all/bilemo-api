<?php

namespace App\Controller\v1;

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
