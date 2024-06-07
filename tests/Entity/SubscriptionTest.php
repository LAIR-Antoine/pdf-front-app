<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Subscription::class)]
class SubscriptionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $subscription = new Subscription();
        
        $subscription->setTitle('Basic Plan');
        $this->assertSame('Basic Plan', $subscription->getTitle());
        
        $subscription->setDescription('Basic subscription plan');
        $this->assertSame('Basic subscription plan', $subscription->getDescription());
        
        $subscription->setPdfLimit(10);
        $this->assertSame(10, $subscription->getPdfLimit());
        
        $subscription->setPrice(999);
        $this->assertSame(999, $subscription->getPrice());
        
        $subscription->setMedia('media.jpg');
        $this->assertSame('media.jpg', $subscription->getMedia());
    }
}
