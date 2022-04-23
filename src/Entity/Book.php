<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $topic;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $publishedDate;

    /**
     * @ORM\OneToMany(targetEntity=BookTag::class, mappedBy="book")
     */
    private $bookTags;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->bookTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(\DateTimeInterface $published_date): self
    {
        $this->publishedDate = $published_date;

        return $this;
    }

    /**
     * @return Collection<int, BookTag>
     */
    public function getBookTags(): Collection
    {
        return $this->bookTags;
    }

    public function addBookTag(BookTag $bookTag): self
    {
        if (!$this->bookTags->contains($bookTag)) {
            $this->bookTags[] = $bookTag;
            $bookTag->setBook($this);
        }

        return $this;
    }

    public function removeBookTag(BookTag $bookTag): self
    {
        if ($this->bookTags->removeElement($bookTag)) {
            // set the owning side to null (unless already changed)
            if ($bookTag->getBook() === $this) {
                $bookTag->setBook(null);
            }
        }

        return $this;
    }
}
