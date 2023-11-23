<?php

namespace App\Tests;

use App\Entity\Auction;
use App\Entity\Raise;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RaiseTest extends KernelTestCase
{
    public const SHOULD_BE_POSITIVE_ERROR = 'This value should be positive.';
    public const SHOULD_BE_ENOUGH = 'Value must be greater than highest raise';
    protected ValidatorInterface $validator;
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        $this->raise = $this->createMock(Raise::class);
        $this->container = self::getContainer();
        $this->validator = $this->container->get(ValidatorInterface::class);
    }

    public function test_price_should_not_be_negative(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());

        $raise = new Raise();
        $raise->setPrice(-10);
        $errors = $this->validator->validate($raise);
        $this->assertNotEmpty($errors);
        $this->assertCount(2, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_POSITIVE_ERROR, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_ENOUGH, $errors);
    }

    public function test_price_should_be_enough(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());

        $raise = new Raise();
        $raise->setPrice(4);
        $errors = $this->validator->validate($raise);
        $this->assertNotEmpty($errors);
        $this->assertCount(1, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_ENOUGH, $errors[0]->getMessage());
    }

    public function test_price_should_be_valid(): void
    {
        $kernel = self::bootKernel();
        $this->assertSame('test', $kernel->getEnvironment());

        $raise = new Raise();
        $raise->setPrice(5 * 100);
        $errors = $this->validator->validate($raise);
        $this->assertEmpty($errors);
        $this->assertCount(0, $errors);
    }

    public function test_last_raise(): void
    {
        $this->assertSame('test', self::bootKernel()->getEnvironment());
        $auction = new Auction();
        $auction->addRaise($this->raise);
        $this->raise->expects($this->once())
            ->method('getLastRaise')
            ->willReturn($auction->getRaises()->last());
        $this->assertEquals($this->raise, $this->raise->getLastRaise());
    }
}
