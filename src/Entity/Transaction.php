<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Loan;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $User;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $receive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $send;
    // public function __construct(){
    //
    // }
    public function __construct(?\DateTimeInterface $date,?int $Loan,?int $User){
      $this->date = $date;
$this->Loan = $Loan;
$this->User = $User;
    }
  //   public function __construct(?\DateTimeInterface $date,?int $Loan,?int $User,?int $receive,?int $send){
  //       $this->date = $date;
  // $this->Loan = $Loan;
  // $this->User = $User;
  //   $this->receive = $receive;
  //   $this->send=$send;
  //   }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getLoan(): ?int
    {
        return $this->Loan;
    }

    public function setLoan(?int $Loan): self
    {
        $this->Loan = $Loan;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->User;
    }

    public function setUser(?int $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getReceive(): ?int
    {
        return $this->receive;
    }

    public function setReceive(?int $receive): self
    {
        $this->receive = $receive;

        return $this;
    }

    public function getSend(): ?int
    {
        return $this->send;
    }

    public function setSend(?int $send): self
    {
        $this->send = $send;

        return $this;
    }


}
