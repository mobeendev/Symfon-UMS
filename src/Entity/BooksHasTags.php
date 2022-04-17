<?php

namespace App\Entity;

use App\Repository\BooksHasTagsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksHasTagsRepository::class)
 */
class BooksHasTags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="Tag")
     */
    private $Book;

    /**
     * @ORM\ManyToOne(targetEntity=Tags::class, inversedBy="Books")
     */
    private $Tag;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->Book;
    }

    public function setBook(?Book $Book): self
    {
        $this->Book = $Book;

        return $this;
    }

    public function getTag(): ?Tags
    {
        return $this->Tag;
    }

    public function setTag(?Tags $Tag): self
    {
        $this->Tag = $Tag;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
