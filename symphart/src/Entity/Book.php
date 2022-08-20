<?php

namespace App\Entity;

use App\Repository\BookRepository;
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
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="integer")
     */
    private $author_id;

    /**
     * @ORM\Column(type="date")
     */
    private $publish_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $book_image;


    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $book_description;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publish_date;
    }

    public function setPublishDate(\DateTimeInterface $publish_date): self
    {
        $this->publish_date = $publish_date;

        return $this;
    }

    public function getBookImage(): ?string
    {
        return $this->book_image;
    }

    public function setBookImage(?string $book_image): self
    {
        $this->book_image = $book_image;

        return $this;
    }

    public function getBookDescription(): ?string
    {
        return $this->book_description;
    }

    public function setBookDescription(?string $book_description): self
    {
        $this->book_description = $book_description;

        return $this;
    }
}
