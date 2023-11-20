<?php

namespace App\Controller;

use App\Repository\AuctionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuctionRepository $auctionRepository): Response
    {
        $auctions = $auctionRepository->findAll();
        return $this->render('home/index.html.twig', [
            'auctions' => $auctions,
        ]);
    }
}
