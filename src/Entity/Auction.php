<?php

namespace App\Entity;

use App\Repository\AuctionRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Status;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: AuctionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Broadcast]
class Auction implements TranslatableInterface
{
    use TranslatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateOpen = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateClose = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'string', enumType: Status::class)]
    private ?Status $status = null;

    #[ORM\OneToMany(mappedBy: 'auction', targetEntity: Raise::class, cascade: ['remove'])]
    private Collection $raises;

    public function __construct()
    {
        $this->raises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->translate()->getTitle();
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

    public function getDescription(): ?string
    {
        return $this->translate()->getDescription();
    }

    public function getDateOpen(): ?\DateTimeInterface
    {
        return $this->dateOpen;
    }

    public function setDateOpen(\DateTimeInterface $dateOpen): static
    {
        $this->dateOpen = $dateOpen;

        return $this;
    }

    public function getDateClose(): ?\DateTimeInterface
    {
        return $this->dateClose;
    }

    public function setDateClose(\DateTimeInterface $dateClose): static
    {
        $this->dateClose = $dateClose;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Raise>
     */
    public function getRaises(): Collection
    {
        return $this->raises;
    }

    public function addRaise(Raise $raise): static
    {
        if (!$this->raises->contains($raise)) {
            $this->raises->add($raise);
            $raise->setAuction($this);
        }

        return $this;
    }

    public function removeRaise(Raise $raise): static
    {
        if ($this->raises->removeElement($raise)) {
            // set the owning side to null (unless already changed)
            if ($raise->getAuction() === $this) {
                $raise->setAuction(null);
            }
        }

        return $this;
    }
}
