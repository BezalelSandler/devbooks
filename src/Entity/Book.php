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
    private $Title;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, inversedBy="books")
     */
    private $Author_ID;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Cover;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Pub_Date;

    public function __construct()
    {
        $this->Author_ID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthorID(): Collection
    {
        return $this->Author_ID;
    }

    public function addAuthorID(Author $authorID): self
    {
        if (!$this->Author_ID->contains($authorID)) {
            $this->Author_ID[] = $authorID;
        }

        return $this;
    }

    public function removeAuthorID(Author $authorID): self
    {
        $this->Author_ID->removeElement($authorID);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->Cover;
    }

    public function setCover(?string $Cover): self
    {
        $this->Cover = $Cover;

        return $this;
    }

    public function getPubDate(): ?\DateTimeInterface
    {
        return $this->Pub_Date;
    }

    public function setPubDate(?\DateTimeInterface $Pub_Date): self
    {
        $this->Pub_Date = $Pub_Date;

        return $this;
    }
}
