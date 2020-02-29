<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User  implements UserInterface , \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @ORM\Column(type="string",length=200)
     */
     private $name;
     /**
      * @ORM\Column(type="string",length=200)
      */
      private $address;
      /**
       * @ORM\Column(type="string",length=200)
       */
       private $mail;

       /**
        * @ORM\Column(type="string", length=200)
        */
       private $user_name;


       /**
        * @ORM\Column(type="string", length=255)
        */
       private $password;
       // min
public $getplainPassword;

       /**
        * @ORM\Column(type="boolean")
        */
       private $isAdmin;

       /**
        * @ORM\Column(type="boolean")
        */
       private $isCreditor;

       /**
        * @ORM\Column(type="boolean")
        */
       private $isDebtor;

       /**
        * @ORM\Column(type="boolean")
        */
       private $isGuarantor;

       /**
        * @ORM\Column(type="integer", nullable=true)
        */
       private $money;

       /**
        * @ORM\Column(type="string", length=20, nullable=true)
        */
       private $WhatsApp;
       public function getname()   {
           return $this->name;
       }
       public function setname($name): void {
            $this->name= $name;
       }

       public function getaddress()   {
           return $this->address;
       }
       public function setaddress($address): void {
            $this->address= $address;
       }

       public function getmail()   {
           return $this->mail;
       }
       public function setmail($mail): void {
            $this->mail= $mail;
       }

       public function getUserName(): ?string
       {
           return $this->user_name;
       }

       public function setUserName(string $user_name): self
       {
           $this->user_name = $user_name;

           return $this;
       }

       public function getPassword(): ?string
       {
           return $this->password;
       }

       public function setPassword(string $password): self
       {
           $this->password = $password;

           return $this;
       }
       public function getSalt()
{

    return null;
}
       public function getRoles()
  {
      return array('ROLE_USER');
  }

  public function eraseCredentials()
  {
    return null;
  }

       /** @see \Serializable::serialize() */
         public function serialize()
         {
             return serialize(array(
                 $this->id,
                 $this->user_name,
                 $this->password,
                 // see section on salt below
                 // $this->salt,
             ));
         }

         /** @see \Serializable::unserialize() */
         public function unserialize($serialized)
         {
             list (
                 $this->id,
                 $this->user_name,
                 $this->password,
                 // see section on salt below
                 // $this->salt
             ) = unserialize($serialized, array('allowed_classes' => false));
         }

         public function getIsAdmin(): ?bool
         {
             return $this->isAdmin;
         }

         public function setIsAdmin(bool $isAdmin): self
         {
             $this->isAdmin = $isAdmin;

             return $this;
         }

         public function getIsCreditor(): ?bool
         {
             return $this->isCreditor;
         }

         public function setIsCreditor(bool $isCreditor): self
         {
             $this->isCreditor = $isCreditor;

             return $this;
         }

         public function getIsDebtor(): ?bool
         {
             return $this->isDebtor;
         }

         public function setIsDebtor(bool $isDebtor): self
         {
             $this->isDebtor = $isDebtor;

             return $this;
         }

         public function getIsGuarantor(): ?bool
         {
             return $this->isGuarantor;
         }

         public function setIsGuarantor(bool $isGuarantor): self
         {
             $this->isGuarantor = $isGuarantor;

             return $this;
         }

         public function getMoney(): ?int
         {
             return $this->money;
         }

         public function setMoney(?int $money): self
         {
             $this->money = $money;

             return $this;
         }

         public function getWhatsApp(): ?string
         {
             return $this->WhatsApp;
         }

         public function setWhatsApp(?string $WhatsApp): self
         {
             $this->WhatsApp = $WhatsApp;

             return $this;
         }
}
