<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MsgRepository")
 */
class Msg
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $userTo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $watch;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $result;

    /**
     * @ORM\Column(type="boolean")
     */
    private $typeMsg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userFrom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $LoanId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reply;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $subject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUserTo(): ?int
    {
        return $this->userTo;
    }

    public function setUserTo(int $userTo): self
    {
        $this->userTo = $userTo;

        return $this;
    }

    public function getWatch(): ?bool
    {
        return $this->watch;
    }

    public function setWatch(bool $watch): self
    {
        $this->watch = $watch;

        return $this;
    }

    public function getResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(?bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getTypeMsg(): ?bool
    {
        return $this->typeMsg;
    }

    public function setTypeMsg(bool $typeMsg): self
    {
        $this->typeMsg = $typeMsg;

        return $this;
    }

    public function getUserFrom(): ?int
    {
        return $this->userFrom;
    }

    public function setUserFrom(?int $userFrom): self
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    public function getLoanId(): ?int
    {
        return $this->LoanId;
    }

    public function setLoanId(?int $LoanId): self
    {
        $this->LoanId = $LoanId;

        return $this;
    }

    public function getReply(): ?int
    {
        return $this->reply;
    }

    public function setReply(?int $reply): self
    {
        $this->reply = $reply;

        return $this;
    }

    public function getSubject(): ?int
    {
        return $this->subject;
    }

    public function setSubject(?int $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
