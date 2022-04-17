<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    public function __toString()
    {
        return $this->tag;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=BooksHasTags::class, mappedBy="Tag")
     */
    private $Books;

    public function __construct()
    {
        $this->Books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, BooksHasTags>
     */
    public function getBooks(): Collection
    {
        return $this->Books;
    }

    public function addBook(BooksHasTags $book): self
    {
        if (!$this->Books->contains($book)) {
            $this->Books[] = $book;
            $book->setTag($this);
        }

        return $this;
    }

    public function removeBook(BooksHasTags $book): self
    {
        if ($this->Books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getTag() === $this) {
                $book->setTag(null);
            }
        }

        return $this;
    }
}
