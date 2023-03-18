<?php

namespace App\Entity;

use App\Repository\ContactFormRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactFormRepository::class)]
class ContactForm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $nameContact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $surnameContact = null;

    #[ORM\Column(length: 255)]
    private ?string $emailContact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentMessage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNameContact(): ?string
    {
        return $this->nameContact;
    }

    public function setNameContact(?string $name): void
    {
        $this->nameContact = $name;
    }

    public function getSurnameContact(): ?string
    {
        return $this->surnameContact;
    }

    public function setSurnameContact(?string $surnameContact): void
    {
        $this->surnameContact = $surnameContact;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getContentMessage(): ?string
    {
        return $this->contentMessage;
    }

    public function setContentMessage(string $contentMessage): self
    {
        $this->contentMessage = $contentMessage;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->dateMessage;
    }

    public function setDateMessage(\DateTimeInterface $dateMessage): self
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }
}
