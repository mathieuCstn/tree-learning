<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserDetail;
use App\Factory\DegreeFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuizFactory;
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
        DegreeFactory::createMany(10);

        $adminUser = new User();
        $adminUser
            ->setFirstName('john')
            ->setLastName('doe')
            ->setPassword($this->userPasswordHasher->hashPassword($adminUser, 'password'))
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN'])
            ->addDegree(DegreeFactory::random())
        ;

        $adminUserDetail = new UserDetail();
        $adminUserDetail
            ->setBio('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis illum, pariatur suscipit ullam ipsa recusandae cumque. Excepturi dignissimos dolores minima corporis iure! Doloribus laboriosam natus veritatis, nihil, laudantium quasi eaque.')
            ->setGithubLink('https://github.com/johndoe')
            ->setPersonalWebsite('johndoe.com')
        ;

        $adminUser->setUserDetail($adminUserDetail);

        $manager->persist($adminUserDetail);
        $manager->persist($adminUser);
        $manager->flush();

        UserFactory::createMany(19, [
            'degrees' => DegreeFactory::randomRange(0, 4)
        ]);

        QuestionFactory::createMany(120);
        QuizFactory::createMany(10, [
            'questions' => QuestionFactory::randomRange(4, 16)
        ]);
    }
}
