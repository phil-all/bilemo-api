<?php

namespace App\Controller\v2;

use App\Repository\ClientRepository;
use App\Service\Google\GoogleInspector;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\RequestValidator\RequestValidator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * GoogleController class
 * @package App\Controller\v2
 *
 * @Route("/api/v2/connect/google")
 */
class GoogleOauthController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("", name="connect_google_login")
     *
     * @param ClientRegistry $clientRegistry
     *
     * @return RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry): RedirectResponse
    {
        $scopes  = ['https://www.googleapis.com/auth/userinfo.email'];
        $options = [];

        return $clientRegistry
            ->getClient('google')
            ->redirect($scopes, $options);
    }

    /**
     * Google redirected back here afterward
     *
     * @Route("/check", name="connect_google_check")
     *
     * @param ClientRepository $clientRepository
     * @param RequestValidator $validator
     * @param GoogleInspector  $google
     *
     * @return JsonResponse|RedirectResponse
     */
    public function connectCheckAction(
        ClientRepository $clientRepository,
        RequestValidator $validator,
        GoogleInspector $google
    ): JsonResponse|RedirectResponse {

        if ($validator->isQueryParamExists('error')) {
            return $this->redirectToRoute('connect_google_check_failed');
        }

        $googleIdToken = $google->getIdToken();

        $email = $google->getEmail();

        if (!$clientRepository->isClientExist($email)) {
            return $this->redirectToRoute('connect_google_check_failed');
        }

        return $this->json(
            [
                'token' => $googleIdToken
            ],
            200
        );
    }

    /**
     * Connection failed
     *
     * @Route("/failed", name="connect_google_check_failed")
     *
     * @return JsonResponse
     */
    public function connectFailed(): JsonResponse
    {
        return new JsonResponse(
            [
                'error' => 'Access denied',
            ],
            403
        );
    }
}
