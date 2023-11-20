<?php

namespace App\Controller;

use App\Entity\Auction;
use App\Entity\Raise;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/raise')]
class RaiseController extends AbstractController
{
    #[Route('/{id}/add', name: 'app_raise_add')]
    public function add(Request $request, Auction $auction, EntityManagerInterface $entityManager): Response
    {
        $price = (int) $request->get('price');
        $raise = new Raise();
        $raise->setAuction($auction);
        $raise->setPrice($price);
        $raise->setCreatedAt(new DateTimeImmutable());
        $entityManager->persist($raise);
        $entityManager->flush();
        $this->addFlash('success', 'Raise has been successfully created');
        return $this->redirectToRoute('app_home');
    }
}
