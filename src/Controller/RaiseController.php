<?php

namespace App\Controller;

use App\Entity\Auction;
use App\Entity\Raise;
use App\Repository\RaiseRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/raise')]
class RaiseController extends AbstractController
{
    #[Route('/{id}/add', name: 'app_raise_add')]
    public function add(Request $request, Auction $auction, EntityManagerInterface $entityManager, RaiseRepository $raiseRepository, ValidatorInterface $validator): Response
    {
        $price = (int) $request->get('price') * 100;
        $raise = new Raise();
        $raise->setAuction($auction);
        $raise->setPrice($price);
        $raise->setCreatedAt(new DateTimeImmutable());
        $errors = $validator->validate($raise);
        if (count($errors)) {
            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->render('home/error.stream.html.twig', [
                    'errors' => $errors
                ]);
            }

            $this->addFlash('danger', $price.' must be greater than highest raise');
            return $this->redirectToRoute('app_home');
        }
        $entityManager->persist($raise);
        $entityManager->flush();

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('home/success.stream.html.twig');
        }

        $this->addFlash('success', 'Raise has been successfully created');
        return $this->redirectToRoute('app_home');
    }
}
