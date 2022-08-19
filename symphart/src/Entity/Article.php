<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    public function __toString(){
        return (string) $this->name;
    }

    // Getters & Setters
    public function getId(){
        return $this->id;
    }

    public function getTitle():string{
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBody(string $body = ''){
        $this->body = $body;
    }

}
