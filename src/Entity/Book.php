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
    const STATUS_RENTED = 0;
    const STATUS_REQUESTED = 1;
    const STATUS_RETURNED = 2;

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
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $publishedDate;

    /**
     * @ORM\OneToMany(targetEntity=BookTag::class, mappedBy="book",
     * fetch="EXTRA_LAZY",
     *  orphanRemoval=true,
     *  cascade={"persist"}
     * )
     */
    private $bookTags;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $isBooked;

    /**
     * @ORM\OneToMany(targetEntity=Borrow::class, mappedBy="book")
     */
    private $borrows;

    /**
     * @ORM\OneToMany(targetEntity=BookingRequest::class, mappedBy="book")
     */
    private $bookingRequests;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->bookTags = new ArrayCollection();
        $this->borrows = new ArrayCollection();
        $this->bookingRequests = new ArrayCollection();
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

    public function addBookTag(BookTag $bookTag)
    {   
        if ($this->bookTags->contains($bookTag)) {
            return ;
        }

        $this->bookTags[] = $bookTag;
        // needed to update the owning side of the relationship!
        $bookTag->setBook($this);

        return $this;
    }

    public function removeBookTag(BookTag $bookTag)
    {
        if ($this->bookTags->removeElement($bookTag)) {
            // set the owning side to null (unless already changed)
            if ($bookTag->getBook() === $this) {
                $bookTag->setBook(null);
            }
        }

        return $this;
    }

    public function getIsBooked(): ?int
    {
        return $this->isBooked;
    }

    public function setIsBooked(?int $isBooked): self
    {
        $this->isBooked = $isBooked;

        return $this;
    }

    /**
     * @return Collection<int, Borrow>
     */
    public function getBorrows(): Collection
    {
        return $this->borrows;
    }

    public function addBorrow(Borrow $borrow): self
    {
        if (!$this->borrows->contains($borrow)) {
            $this->borrows[] = $borrow;
            $borrow->setBook($this);
        }

        return $this;
    }

    public function removeBorrow(Borrow $borrow): self
    {
        if ($this->borrows->removeElement($borrow)) {
            // set the owning side to null (unless already changed)
            if ($borrow->getBook() === $this) {
                $borrow->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookingRequest>
     */
    public function getBookingRequests(): Collection
    {
        return $this->bookingRequests;
    }

    public function addBookingRequest(BookingRequest $bookingRequest): self
    {
        if (!$this->bookingRequests->contains($bookingRequest)) {
            $this->bookingRequests[] = $bookingRequest;
            $bookingRequest->setBook($this);
        }

        return $this;
    }

    public function removeBookingRequest(BookingRequest $bookingRequest): self
    {
        if ($this->bookingRequests->removeElement($bookingRequest)) {
            // set the owning side to null (unless already changed)
            if ($bookingRequest->getBook() === $this) {
                $bookingRequest->setBook(null);
            }
        }

        return $this;
    }
}
