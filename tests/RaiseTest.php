<?php

namespace App\Tests;

use App\Entity\Auction;
use App\Entity\Raise;
use App\Repository\RaiseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RaiseTest extends KernelTestCase
{
    public const SHOULD_BE_POSITIVE_ERROR = 'This value should be positive.';
    public const SHOULD_BE_ENOUGH = 'Value must be greater than highest raise';

    public function test_price_should_not_be_negative(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $this->assertSame('test', $kernel->getEnvironment());
        $validator = $container->get(ValidatorInterface::class);

        $raise = new Raise();
        $raise->setPrice(-10);
        $errors = $validator->validate($raise);
        $this->assertNotEmpty($errors);
        $this->assertCount(2, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_POSITIVE_ERROR, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_ENOUGH, $errors);
    }

    public function test_price_should_be_enough(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $this->assertSame('test', $kernel->getEnvironment());
        $validator = $container->get(ValidatorInterface::class);

        $raise = new Raise();
        $raise->setPrice(4);
        $errors = $validator->validate($raise);
        $this->assertNotEmpty($errors);
        $this->assertCount(1, $errors);
        $this->assertStringContainsString(self::SHOULD_BE_ENOUGH, $errors[0]->getMessage());
    }

    public function test_price_should_be_valid(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $this->assertSame('test', $kernel->getEnvironment());
        $validator = $container->get(ValidatorInterface::class);

        $raise = new Raise();
        $raise->setPrice(5 * 100);
        $errors = $validator->validate($raise);
        $this->assertEmpty($errors);
        $this->assertCount(0, $errors);
    }
}
