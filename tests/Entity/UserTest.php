<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(User::class)]
class UserTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $user = new User();
        
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());
        
        $user->setPassword('password');
        $this->assertSame('password', $user->getPassword());
        
        $user->setFirstname('John');
        $this->assertSame('John', $user->getFirstname());
        
        $user->setLastname('Doe');
        $this->assertSame('Doe', $user->getLastname());

        $roles = ['ROLE_USER'];
        $user->setRoles($roles);
        $this->assertSame($roles, $user->getRoles());
        
        $createdAt = new \DateTimeImmutable();
        $user->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $user->getCreatedAt());
        
        $updatedAt = new \DateTimeImmutable();
        $user->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $user->getUpdatedAt());

        $subscriptionEndAt = new \DateTimeImmutable();
        $user->setSubscriptionEndAt($subscriptionEndAt);
        $this->assertSame($subscriptionEndAt, $user->getSubscriptionEndAt());
    }
}
