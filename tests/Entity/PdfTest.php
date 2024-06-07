<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Pdf;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Pdf::class)]
class PdfTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $pdf = new Pdf();
        
        $pdf->setTitle('Sample PDF');
        $this->assertSame('Sample PDF', $pdf->getTitle());
        
        $createdAt = new \DateTimeImmutable();
        $pdf->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $pdf->getCreatedAt());

    }
}
