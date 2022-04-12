<?php

namespace App\Service\Pager;

use App\Service\RequestInspector\RequestInspector;

/**
 * Helper for pager service
 * @package App\Service\Pager
 */
trait Helper
{
    /**
     * Get the current page from query request
     *
     * @return integer
     */
    private function getCurrentPage(RequestInspector $requestInspector): int
    {
        return (int)$requestInspector->getQueryParameter('page') !== 0
            ? (int)$requestInspector->getQueryParameter('page')
            : 1
        ;
    }
}
