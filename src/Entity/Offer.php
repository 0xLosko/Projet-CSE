<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleOffer = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionOffer = null;

    #[ORM\Column(length: 255)]
    private ?int $typeOffer = null;
    #[ORM\Column(length: 255)]
    private ?string $linkOffer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDateDisplay = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateDisplay = null;

    #[ORM\Column(nullable: true)]
    private ?int $sortNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDateValid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDateValid = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberPlaces = null;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: File::class)]
    private Collection $file;

    public function __construct()
    {
        $this->file = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleOffer(): ?string
    {
        return $this->titleOffer;
    }

    public function setTitleOffer(string $titleOffer): self
    {
        $this->titleOffer = $titleOffer;

        return $this;
    }

    public function getDescriptionOffer(): ?string
    {
        return $this->descriptionOffer;
    }

    public function setDescriptionOffer(string $descriptionOffer): self
    {
        $this->descriptionOffer = $descriptionOffer;

        return $this;
    }
    public function getTypeOffer(): ?int
    {
        return $this->typeOffer;
    }
    public function setTypeOffer(?int $typeOffer): void
    {
        $this->typeOffer = $typeOffer;
    }

    public function getLinkOffer(): ?string
    {
        return $this->linkOffer;
    }

    public function setLinkOffer(string $linkOffer): self
    {
        $this->linkOffer = $linkOffer;

        return $this;
    }

    public function getStartDateDisplay(): ?\DateTimeInterface
    {
        return $this->startDateDisplay;
    }

    public function setStartDateDisplay(?\DateTimeInterface $startDateDisplay): self
    {
        $this->startDateDisplay = $startDateDisplay;

        return $this;
    }

    public function getEndDateDisplay(): ?\DateTimeInterface
    {
        return $this->endDateDisplay;
    }

    public function setEndDateDisplay(?\DateTimeInterface $endDateDisplay): self
    {
        $this->endDateDisplay = $endDateDisplay;

        return $this;
    }

    public function getSortNumber(): ?int
    {
        return $this->sortNumber;
    }

    public function setSortNumber(?int $sortNumber): self
    {
        $this->sortNumber = $sortNumber;

        return $this;
    }

    public function getStartDateValid(): ?\DateTimeInterface
    {
        return $this->startDateValid;
    }

    public function setStartDateValid(?\DateTimeInterface $startDateValid): self
    {
        $this->startDateValid = $startDateValid;

        return $this;
    }

    public function getEndDateValid(): ?\DateTimeInterface
    {
        return $this->endDateValid;
    }

    public function setEndDateValid(?\DateTimeInterface $endDateValid): self
    {
        $this->endDateValid = $endDateValid;

        return $this;
    }

    public function getNumberPlaces(): ?int
    {
        return $this->numberPlaces;
    }

    public function setNumberPlaces(?int $numberPlaces): self
    {
        $this->numberPlaces = $numberPlaces;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFile(): Collection
    {
        return $this->file;
    }

    public function addFile(File $file): self
    {
        if (!$this->file->contains($file)) {
            $this->file->add($file);
            $file->setOffer($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->file->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getOffer() === $this) {
                $file->setOffer(null);
            }
        }

        return $this;
    }
}
