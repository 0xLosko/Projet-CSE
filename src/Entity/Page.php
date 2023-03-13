<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $namePage = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: ContentPage::class)]
    private Collection $contentPages;

    public function __construct()
    {
        $this->contentPages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePage(): ?string
    {
        return $this->namePage;
    }

    public function setNamePage(string $namePage): self
    {
        $this->namePage = $namePage;

        return $this;
    }

    /**
     * @return Collection<int, ContentPage>
     */
    public function getContentPages(): Collection
    {
        return $this->contentPages;
    }

    public function addContentPage(ContentPage $contentPage): self
    {
        if (!$this->contentPages->contains($contentPage)) {
            $this->contentPages->add($contentPage);
            $contentPage->setPage($this);
        }

        return $this;
    }

    public function removeContentPage(ContentPage $contentPage): self
    {
        if ($this->contentPages->removeElement($contentPage)) {
            // set the owning side to null (unless already changed)
            if ($contentPage->getPage() === $this) {
                $contentPage->setPage(null);
            }
        }

        return $this;
    }
}
