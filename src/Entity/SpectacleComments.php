<?php

namespace App\Entity;

use App\Repository\SpectacleCommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpectacleCommentsRepository::class)]
class SpectacleComments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'spectacleComments')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'spectacleComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spectacles $spectacle = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 1000)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSpectacle(): ?spectacles
    {
        return $this->spectacle;
    }

    public function setSpectacle(?spectacles $spectacle): self
    {
        $this->spectacle = $spectacle;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
