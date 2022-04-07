<?php

namespace App\Service\Google;

use League\OAuth2\Client\Provider\Google;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 * Provider class
 * @package App\Service\Google
 */
class Provider
{
    /**
     * @var ContainerBagInterface
     */
    private ContainerBagInterface $container;

    /**
     * Provider constructor
     *
     * @param ContainerBagInterface $container
     */
    public function __construct(ContainerBagInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Get own provider
     *
     * @return Google
     */
    public function getProvider(): Google
    {
        return new Google([
            'clientId'     => $this->container->get('oauth.google.client.id'),
            'clientSecret' => $this->container->get('oauth.google.client.secret'),
            'redirectUri'  => $this->container->get('oauth.google.redirect.uri'),
            'accessType'   => 'offline',
        ]);
    }
}
