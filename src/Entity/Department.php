<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $establishedDate;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=DepartmentCode::class, mappedBy="department")
     */
    private $departmentCodes;

    public function __construct()
    {
        $this->departmentCodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEstablishedDate(): ?\DateTimeInterface
    {
        return $this->establishedDate;
    }

    public function setEstablishedDate(\DateTimeInterface $establishedDate): self
    {
        $this->establishedDate = $establishedDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, DepartmentCode>
     */
    public function getDepartmentCodes(): Collection
    {
        return $this->departmentCodes;
    }

    public function addDepartmentCode(DepartmentCode $departmentCode): self
    {
        if (!$this->departmentCodes->contains($departmentCode)) {
            $this->departmentCodes[] = $departmentCode;
            $departmentCode->setDepartment($this);
        }

        return $this;
    }

    public function removeDepartmentCode(DepartmentCode $departmentCode): self
    {
        if ($this->departmentCodes->removeElement($departmentCode)) {
            // set the owning side to null (unless already changed)
            if ($departmentCode->getDepartment() === $this) {
                $departmentCode->setDepartment(null);
            }
        }

        return $this;
    }
}
