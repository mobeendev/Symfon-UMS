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
     * @ORM\OneToMany(targetEntity=BooksHasTags::class, mappedBy="Book")
     */
    public $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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
     * @return Collection<int, BooksHasTags>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(BooksHasTags $tag): self
    {
        // if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
            $tag->setBook($this);
        // }

        return $this;
    }

    public function removeTag(BooksHasTags $tag): self
    {
        if ($this->tag->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getBook() === $this) {
                $tag->setBook(null);
            }
        }

        return $this;
    }
}
