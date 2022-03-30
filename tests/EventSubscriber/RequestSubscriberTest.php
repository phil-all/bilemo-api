<?php

namespace App\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use App\EventSubscriber\RequestSubscriber;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * RequestSubscriberTest class
 */
class RequestSubscriberTest extends TestCase
{
    /**
     * Test if RequestSubscriber subsribe to RequestEvent
     *
     * @return void
     */
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(RequestEvent::class, RequestSubscriber::getSubscribedEvents());
    }
}
