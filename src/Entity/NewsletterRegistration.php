<?php

namespace App\Entity;

use App\Repository\NewsletterRegistrationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRegistrationRepository::class)]
class NewsletterRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $emailSubscriber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateSubscriber = null;

    #[ORM\Column]
    private ?bool $cguAccepted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailSubscriber(): ?string
    {
        return $this->emailSubscriber;
    }

    public function setEmailSubscriber(string $emailSubscriber): self
    {
        $this->emailSubscriber = $emailSubscriber;

        return $this;
    }

    public function getDateSubscriber(): ?\DateTimeInterface
    {
        return $this->dateSubscriber;
    }

    public function setDateSubscriber(\DateTimeInterface $dateSubscriber): self
    {
        $this->dateSubscriber = $dateSubscriber;

        return $this;
    }

    public function isCguAccepted(): ?bool
    {
        return $this->cguAccepted;
    }

    public function setCguAccepted(bool $cguAccepted): self
    {
        $this->cguAccepted = $cguAccepted;

        return $this;
    }
}
