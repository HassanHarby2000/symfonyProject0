<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeelingRepository")
 */
class Feeling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $decrease;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $increase;

    public function __construct(?\DateTimeInterface $date,?int $User){
      $this->date = $date;
 
$this->user = $User;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDecrease(): ?int
    {
        return $this->decrease;
    }

    public function setDecrease(?int $decrease): self
    {
        $this->decrease = $decrease;

        return $this;
    }

    public function getIncrease(): ?int
    {
        return $this->increase;
    }

    public function setIncrease(?int $increase): self
    {
        $this->increase = $increase;

        return $this;
    }
}
