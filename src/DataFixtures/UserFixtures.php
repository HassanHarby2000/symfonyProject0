<?php

namespace App\DataFixtures;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
  private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
   {
         $this->passwordEncoder = $passwordEncoder;
    }

//     public function register(UserPasswordEncoderInterface $encoder)
// {
//     // whatever *your* User object is
//     $user = new App\Entity\User();
//     $plainPassword = 'ryanpass';
//     $encoded = $encoder->encodePassword($user, $plainPassword);
//
//     $user->setPassword($encoded);
// }
    public function load(ObjectManager $manager)
    {
      $user = new User();

      $user->setname('hasan');
      $user->setaddress('1999');
      $user->setmail('asa20000928@gmail.com');
      $user->setUserName('hassanharby');

   $user->setPassword($this->passwordEncoder->encodePassword($user,  'new' ));
       $manager->persist($user);

        $manager->flush();
    }
}
