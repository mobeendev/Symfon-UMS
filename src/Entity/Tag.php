<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=BookTag::class, mappedBy="tag")
     */
    private $relatedBooks;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->relatedBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BookTag>
     */
    public function getRelatedBooks(): Collection
    {
        return $this->relatedBooks;
    }

    public function addRelatedBook(BookTag $relatedBook): self
    {
        if (!$this->relatedBooks->contains($relatedBook)) {
            $this->relatedBooks[] = $relatedBook;
            $relatedBook->setTag($this);
        }

        return $this;
    }

    public function removeRelatedBook(BookTag $relatedBook): self
    {
        if ($this->relatedBooks->removeElement($relatedBook)) {
            // set the owning side to null (unless already changed)
            if ($relatedBook->getTag() === $this) {
                $relatedBook->setTag(null);
            }
        }

        return $this;
    }
}
