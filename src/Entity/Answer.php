<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAnswer = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proposal $proposal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAnswer(): ?\DateTimeInterface
    {
        return $this->dateAnswer;
    }

    public function setDateAnswer(\DateTimeInterface $dateAnswer): self
    {
        $this->dateAnswer = $dateAnswer;

        return $this;
    }

    public function getProposal(): ?Proposal
    {
        return $this->proposal;
    }

    public function setProposal(?Proposal $proposal): self
    {
        $this->proposal = $proposal;

        return $this;
    }
}
