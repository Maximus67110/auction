<?php

namespace App\Twig\Components;

use App\Repository\AuctionRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Search
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $title = '';

    #[LiveProp(writable: true)]
    public ?int $min = null;

    #[LiveProp(writable: true)]
    public ?int $max = null;

    public function __construct(private readonly AuctionRepository $productRepository) {}

    public function getAuctions(): array
    {
        return $this->productRepository->search($this->title, $this->min, $this->max);
    }
}
