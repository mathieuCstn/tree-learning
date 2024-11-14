<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        ($user = new User())
            ->setFirstName('johndoe')
            ->setPassword('password')
            ->setEmail('johndoe@example.com')
        ;
        
        $manager->persist($user);

        $manager->flush();
    }
}
