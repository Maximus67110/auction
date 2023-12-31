<?php

namespace App\Entity;

use App\Repository\RaiseRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaiseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Raise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Positive]
    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'raises')]
    private ?Auction $auction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): static
    {
        $this->auction = $auction;

        return $this;
    }

    #[Assert\IsTrue(message: 'Value must be greater than highest raise')]
    public function isPriceEnough(): bool {
        return $this->price >= (int) $this->getLastRaise()?->getPrice() + 5 * 100;
    }

    public function getLastRaise(): ?Raise
    {
        $raises = $this->getAuction()?->getRaises()->toArray();
        return is_array($raises) ? array_pop($raises) : null;
    }
}
