<?php

namespace App\Factory;

use App\Entity\Degree;
use App\Repository\DegreeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentObjectFactory<Degree>
 */
final class DegreeFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Degree::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $allDegrees = array_merge(...array_values($this->getDegreeTitles()));

        return [
            'name' => self::faker()->randomElement($allDegrees),
            'obtained_at' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Degree $degree): void {})
        ;
    }

    private function getDegreeTitles(): array
    {
        return [
            // Diplômes professionnels
            'professional' => [
                'CAP Développement',
                'BEP Services Numériques',
                'Bac Pro Systèmes Numériques',
                'BTS Services Informatiques aux Organisations',
                'BTS Systèmes Numériques',
                'DUT Informatique',
                'BUT Informatique',
                'BUT Réseaux et Télécommunications',
                'Titre RNCP Développeur Web',
                'Titre RNCP Concepteur Développeur d\'Applications',
                'Titre RNCP Expert en Ingénierie du Logiciel',
            ],

            // Diplômes universitaires
            'university' => [
                'Licence Informatique',
                'Licence MIASHS',
                'Licence Pro Développement Web',
                'Master MIAGE',
                'Master Informatique',
                'Master Génie Logiciel',
                'Master Cybersécurité',
                'Master Intelligence Artificielle',
                'Master Big Data',
                'Doctorat en Informatique',
            ],

            // Diplômes d'écoles
            'engineering' => [
                'Diplôme d\'Ingénieur en Informatique',
                'Diplôme d\'Ingénieur en Cybersécurité',
                'Diplôme d\'Ingénieur en Intelligence Artificielle',
                'Diplôme d\'Ingénieur en Systèmes d\'Information',
                'MSc Computer Science',
                'MSc Artificial Intelligence',
                'MSc Data Science',
            ],

            // Certifications professionnelles
            'certification' => [
                'Certification AWS Solutions Architect',
                'Certification Microsoft Azure Developer',
                'Certification Google Cloud Engineer',
                'Certification Symfony',
                'Certification PHP',
                'Certification Docker',
                'Certification Kubernetes',
                'Certification CISSP',
                'Certification CompTIA Security+',
                'Certification Scrum Master',
            ]
        ];
    }
}
