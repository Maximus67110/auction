<?php

namespace App\Command;

use App\Enum\Status;
use App\Repository\AuctionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:auction:update-status',
    description: 'Update auctions status',
)]
class AuctionsCommand extends Command
{
    public function __construct(
        private readonly AuctionRepository $auctionRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Start auctions status update');

        $auctions = $this->auctionRepository->findAll();
        foreach ($auctions as $auction) {
            if ($auction->getDateOpen() < new DateTime()) {
                $auction->setStatus(Status::VISIBLE);
            }
            if ($auction->getDateClose() < new DateTime()) {
                $auction->setStatus(Status::ARCHIVED);
            }
            $this->entityManager->flush($auction);
        }

        $io->success('Auctions status successfully updated');

        return Command::SUCCESS;
    }
}
