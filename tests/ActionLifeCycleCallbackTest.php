<?php

namespace App\Tests;

use App\Entity\Auction;
use App\Enum\Status;
use App\Repository\AuctionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ActionLifeCycleCallbackTest extends KernelTestCase
{
    public function test_lifecycle_callback_for_auction(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $this->assertSame('test', $kernel->getEnvironment());
        $auctionRepository = $container->get(AuctionRepository::class);
        $entityManager = $container->get(EntityManagerInterface::class);

        $auction = new Auction();
        $auction->setTitle('Auction');
        $auction->setPrice(5);
        $auction->setDescription('description');
        $auction->setDateOpen((new DateTime())->modify('-1 day'));
        $auction->setDateClose((new DateTime())->modify('+1 day'));
        $auction->setImage('image');
        $auction->setStatus(Status::CREATED);
        $this->assertEmpty($auction->getCreatedAt());
        $entityManager->persist($auction);
        $entityManager->flush($auction);
        $databaseAuction = $auctionRepository->findOneBy(['id' => $auction->getId()]);
        $this->assertNotEmpty($databaseAuction->getCreatedAt());
    }
}
