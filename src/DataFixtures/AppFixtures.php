<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();

        $user->setname('hassan');
        $user->setaddress('1999');
        $user->setmail('asa20000928@gmail.com');
        $user->setUserName('hassanharby');

     $user->setPassword($this->passwordEncoder->encodePassword($user,  'new' ));
        //   $manager->persist($user);

          $manager->flush();
    }
}
