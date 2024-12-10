<?php

namespace App\DataFixtures;

use App\Factory\DegreeFactory;
use App\Factory\QuestionFactory;
use App\Factory\QuizFactory;
use App\Factory\UserFactory;
use App\Factory\UserDetailFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const NB_DEGREES = 10;
    private const NB_QUESTIONS = 120;
    private const NB_QUIZZES = 10;
    private const NB_USERS = 19;
    private const MIN_QUESTIONS_PER_QUIZ = 4;
    private const MAX_QUESTIONS_PER_QUIZ = 16;
    private const MAX_DEGREES_PER_USER = 4;

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        DegreeFactory::createMany(self::NB_DEGREES);

        QuestionFactory::createMany(self::NB_QUESTIONS);

        QuizFactory::createMany(self::NB_QUIZZES, function() {
            $nbQuestions = rand(self::MIN_QUESTIONS_PER_QUIZ, self::MAX_QUESTIONS_PER_QUIZ);

            return [
                'questions' => QuestionFactory::randomRange($nbQuestions, $nbQuestions)
            ];
        });

        UserFactory::createOne([
            'firstName' => 'john',
            'lastName' => 'doe',
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
            'degrees' => DegreeFactory::randomRange(1, 3),
            'userDetail' => UserDetailFactory::createOne([
                'bio' => 'Lorem ipsum...',
                'githubLink' => 'https://github.com/johndoe',
                'personalWebsite' => 'johndoe.com'
            ])
        ]);

        UserFactory::createMany(self::NB_USERS, function() {
            $nbDegrees = rand(0, self::MAX_DEGREES_PER_USER);
            
            return [
                'degrees' => DegreeFactory::randomRange($nbDegrees, $nbDegrees)
            ];
        });
    }
}
