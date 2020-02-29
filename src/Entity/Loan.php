<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoanRepository")
 */
class Loan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $money;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="Loan")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Creditor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="Loan")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Debtor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="Loan")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $First_Guarantor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="Loan")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Second_Guarantor;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreditor(): ?int
    {
        return $this->Creditor;
    }

    public function setCreditor(?int $Creditor): self
    {
        $this->Creditor = $Creditor;

        return $this;
    }

    public function getDebtor(): ?int
    {
        return $this->Debtor;
    }

    public function setDebtor(?int $Debtor): self
    {
        $this->Debtor = $Debtor;

        return $this;
    }

    public function getFirstGuarantor(): ?int
    {
        return $this->First_Guarantor;
    }

    public function setFirstGuarantor(?int $First_Guarantor): self
    {
        $this->First_Guarantor = $First_Guarantor;

        return $this;
    }

    public function getSecondGuarantor(): ?int
    {
        return $this->Second_Guarantor;
    }

    public function setSecondGuarantor(?int $Second_Guarantor): self
    {
        $this->Second_Guarantor = $Second_Guarantor;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
