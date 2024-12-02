<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
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
        $adminUser = new User();
        $adminUser
            ->setFirstName('john')
            ->setLastName('doe')
            ->setPassword($this->userPasswordHasher->hashPassword($adminUser, 'password'))
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN'])
        ;
        
        $manager->persist($adminUser);
        $manager->flush();

        UserFactory::createMany(19);
    }
}
