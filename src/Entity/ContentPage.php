<?php

namespace App\Entity;

use App\Repository\ContentPageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentPageRepository::class)]
class ContentPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $positionPage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textContent = null;

    #[ORM\ManyToOne(inversedBy: 'contentPages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionPage(): ?string
    {
        return $this->positionPage;
    }

    public function setPositionPage(string $positionPage): self
    {
        $this->positionPage = $positionPage;

        return $this;
    }

    public function getTextContent(): ?string
    {
        return $this->textContent;
    }

    public function setTextContent(string $textContent): self
    {
        $this->textContent = $textContent;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }
}
