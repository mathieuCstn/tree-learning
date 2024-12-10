<?php

namespace App\Factory;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Quiz>
 */
final class QuizFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Quiz::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $allTitles = array_merge(...array_values($this->getQuizTitles()));
        $numberOfQuestions = rand(4, 16);

        return [
            'title' => self::faker()->randomElement($allTitles),
            'description' => self::faker()->text(),
            'created_at' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'questions' => QuestionFactory::createMany($numberOfQuestions),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function (Quiz $quiz): void {
            //     $numberOfQuestions = rand(4, 16);
            //     for ($i = 0; $i <= $numberOfQuestions; $i++) {
            //         QuestionFactory::new();
            //     }
            // })
        ;
    }

    private function getQuizTitles(): array
    {
        return [
            // PHP
            'php' => [
                'PHP Les bases',
                'PHP Intermédiaire',
                'PHP Avancé',
                'PHP 8 - Les nouveautés',
                'POO en PHP',
                'Design Patterns en PHP',
                'Tests unitaires en PHP',
            ],

            // Frameworks PHP
            'frameworks' => [
                'Symfony Débutant',
                'Symfony Intermédiaire',
                'Symfony Avancé',
                'Laravel Débutant',
                'Laravel Avancé',
                'API Platform',
            ],

            // Base de données
            'database' => [
                'SQL Fondamentaux',
                'SQL Avancé',
                'Doctrine ORM Basics',
                'Doctrine ORM Avancé',
                'MongoDB pour PHP',
                'Redis avec PHP',
            ],

            // DevOps
            'devops' => [
                'Git Fondamentaux',
                'Git Flow & Stratégies',
                'Docker Débutant',
                'Docker Avancé',
                'CI/CD Basics',
                'CI/CD Avancé avec GitHub Actions',
                'Kubernetes pour PHP',
            ],

            // Architecture
            'architecture' => [
                'Clean Architecture',
                'Architecture Hexagonale',
                'DDD (Domain-Driven Design)',
                'CQRS & Event Sourcing',
                'Microservices avec PHP',
            ],

            // Sécurité
            'security' => [
                'Sécurité Web Fondamentaux',
                'Sécurité Web Avancée',
                'OAuth2 & JWT',
                'OWASP Top 10',
                'Audit de Sécurité PHP',
            ],

            // API
            'api' => [
                'REST API Basics',
                'REST API Avancé',
                'GraphQL Fondamentaux',
                'GraphQL Avancé',
                'API Documentation',
            ],

            // Frontend
            'frontend' => [
                'JavaScript Moderne',
                'TypeScript Fondamentaux',
                'React avec PHP',
                'Vue.js avec PHP',
                'Progressive Web Apps',
            ],

            // Performance
            'performance' => [
                'Optimisation PHP',
                'Cache & Performance',
                'Scalabilité PHP',
                'Monitoring & Logging',
                'Profiling PHP',
            ]
        ];
    }
}
