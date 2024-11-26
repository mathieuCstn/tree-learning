<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ){}
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user
            ->setFirstName('johndoe')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'password'))
            ->setEmail('johndoe@example.com')
        ;
        
        $manager->persist($user);

        $manager->flush();
    }
}
