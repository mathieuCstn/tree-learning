<?php

namespace App\Factory;

use App\Entity\AssessmentSession;
use App\Repository\AssessmentSessionRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<AssessmentSession>
 */
final class AssessmentSessionFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return AssessmentSession::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'userAccount' => UserFactory::new(),
            'completed_at' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'quiz' => QuizFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // todo Définir les choix effectuer dans la relation sessionQuizChoices qui sont liés au quiz de la session.
            // ->afterInstantiate(function(AssessmentSession $assessmentSession): void {
            //     $quiz = $assessmentSession->getQuiz();
            // })
        ;
    }
}
