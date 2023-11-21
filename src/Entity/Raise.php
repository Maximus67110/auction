<?php

namespace App\Entity;

use App\Repository\RaiseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaiseRepository::class)]
class Raise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Expression(
        "value >= this.getLastRaise() + add_value",
        message: 'the value must be greater than highest raise',
        values: ['add_value' => 5 * 100]
    )]
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

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

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

    public function getLastRaise(): ?int
    {
        $array = $this->getAuction()?->getRaises()->toArray();
        if (!count($array)) {
            return null;
        }
        return end($array)->getPrice();
    }
}
