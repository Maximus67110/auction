<?php

namespace App\Tests;

use App\Entity\Auction;
use App\Enum\Status;
use App\Repository\AuctionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Panther\PantherTestCase;

class AddRaiseTest extends PantherTestCase
{
    public function test_add_raise(): void
    {
        $client = static::createPantherClient(['external_base_uri' => 'http://localhost:8000']);
        $crawler = $client->request('GET', '/');
        $client->waitForElementToContain('h1', 'Auction List', 10);

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $auction = new Auction();
        $auction->setTitle('Auction');
        $auction->setPrice(500);
        $auction->setDescription('description');
        $auction->setDateOpen((new DateTime())->modify('-1 day'));
        $auction->setDateClose((new DateTime())->modify('+1 day'));
        $auction->setImage('image');
        $auction->setStatus(Status::VISIBLE);
        $entityManager->persist($auction);
        $entityManager->flush();

        $client->waitForVisibility('#auction'.$auction->getId().' .card-text > p:nth-child(1)');
        self::assertSelectorWillContain('#auction'.$auction->getId().' .card-text > p:nth-child(1)', '5,00 €');
        $form = $crawler->filter('#auction'.$auction->getId().' form')->form([
            "price" => 10
        ]);
        $client->submit($form);
        $client->waitForVisibility('#auction'.$auction->getId().' .card-text > p:nth-child(1)');
        self::assertSelectorWillContain('#auction'.$auction->getId().' .card-text > p:nth-child(1)', '10,00 €');
        $client->waitForVisibility('#auction'.$auction->getId().' .alert-success');
        self::assertSelectorWillContain('#auction'.$auction->getId().' .alert-success', 'Raise successfully created');
    }
}
