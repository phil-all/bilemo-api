<?php

namespace App\Tests\EventSubscriber;

//use PHPUnit\Framework\ErrorTestCase;
use PHPUnit\Framework\TestCase;
use App\EventSubscriber\ExceptionSubscriber;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * ExeptionSubscriberTest class
 */
class ExceptionSubscriberTest extends TestCase
{
    /**
     * Test if RequestSubscriber subsribe to RequestEvent
     *
     * @return void
     */
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }
}
