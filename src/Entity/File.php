<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255)]
    private ?string $fileName = null;

    #[ORM\Column(length: 255)]
    private ?string $altFile = null;

    #[ORM\Column(length: 255)]
    private ?string $pathFile = null;

    #[ORM\Column]
    private ?float $sizeFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFile = null;

    #[ORM\OneToOne(mappedBy: 'idFile', cascade: ['persist', 'remove'])]
    private ?Partner $idFile = null;

    #[ORM\ManyToOne(inversedBy: 'file')]
    private ?Offer $offer = null;

    #[ORM\OneToOne(mappedBy: 'file', cascade: ['persist', 'remove'])]
    private ?Member $member = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getAltFile(): ?string
    {
        return $this->altFile;
    }

    public function setAltFile(string $altFile): self
    {
        $this->altFile = $altFile;

        return $this;
    }

    public function getPathFile(): ?string
    {
        return $this->pathFile;
    }

    public function setPathFile(string $pathFile): self
    {
        $this->pathFile = $pathFile;

        return $this;
    }

    public function getSizeFile(): ?float
    {
        return $this->sizeFile;
    }

    public function setSizeFile(float $sizeFile): self
    {
        $this->sizeFile = $sizeFile;

        return $this;
    }

    public function getDateFile(): ?\DateTimeInterface
    {
        return $this->dateFile;
    }

    public function setDateFile(\DateTimeInterface $dateFile): self
    {
        $this->dateFile = $dateFile;

        return $this;
    }

    public function getIdFile(): ?Partner
    {
        return $this->idFile;
    }

    public function setIdFile(Partner $idFile): self
    {
        // set the owning side of the relation if necessary
        if ($idFile->getIdFile() !== $this) {
            $idFile->setIdFile($this);
        }

        $this->idFile = $idFile;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        // set the owning side of the relation if necessary
        if ($member->getFile() !== $this) {
            $member->setFile($this);
        }

        $this->member = $member;

        return $this;
    }
}
