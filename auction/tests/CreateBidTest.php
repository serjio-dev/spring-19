<?php

namespace App\Tests;

use App\Entity\BidHistory;
use App\Entity\Product;
use App\Entity\User;
use App\Sevices\CreateBid;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateBidTest extends TestCase
{
    /**
     * @var CreateBid
     */
    private $createBid;

    /**
     * @var EntityManager|MockObject
     */
    private $entityManager;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->entityManager = $this->createMock(EntityManager::class);

        $this->createBid = new CreateBid($this->entityManager);
    }

    /**
 * @test
 */
    public function createTrue()
    {
        $user = $this->createMock(User::class);
        $product = $this->createMock(Product::class);

        $user->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $product->expects($this->once())
            ->method('isActive')
            ->willReturn(true);

        $res = $this->createBid->create($user, $product,'678');

        $this->assertTrue($res);
    }

    /**
     * @test
     */
    public function createException()
    {
        $user = $this->createMock(User::class);
        $product = $this->createMock(Product::class);

        $user->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $product->expects($this->once())
            ->method('isActive')
            ->willReturn(true);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        $this->entityManager->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception());

        $this->entityManager->expects($this->once())
            ->method('rollback');

        $res = $this->createBid->create($user, $product,'678');

        $this->assertFalse($res);
    }
}