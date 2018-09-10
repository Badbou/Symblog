<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use \App\Entity\Users;

class User extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1 ; $i<6; $i++)  
        {
            $user = new Users();
            $user->setLastName("lastname".$i)
                ->setName("name".$i)
                ->setEmail("a@a.fr")
                ->setPassword("123456789")
                ->setDateCreate(new \datetime())
                ->setDateLastLogin(new \datetime()); 
            $manager->persist($user);

        }

        $manager->flush();
    }


}
