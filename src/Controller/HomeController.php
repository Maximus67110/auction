<?php

namespace App\Controller;

use App\Enum\Status;
use App\Repository\AuctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuctionRepository $auctionRepository): Response
    {
        $auctions = $auctionRepository->findBy(['status' => Status::VISIBLE]);
        return $this->render('home/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
}
