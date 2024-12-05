<?php

namespace App\Factory;

use App\Entity\UserDetail;
use App\Repository\UserDetailRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<UserDetail>
 */
final class UserDetailFactory extends PersistentProxyObjectFactory{
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
        return UserDetail::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $user = UserFactory::new();
        $userName = self::faker()->userName();

        return [
            'cv' => self::faker()->file('assets/docs/cv', 'public/images/cv'),
            'bio' => self::faker()->text(),
            'githubLink' => 'https://github.com/'.$userName,
            'personalWebsite' => $userName.'.'.self::faker()->tld(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function(UserDetail $userDetail): void {
                $domainName = self::faker()->domainName();
                $userDetail
                    ->setGithubLink('https://github.com/'.preg_replace('/\.[a-z]+$/i', '', $domainName))
                    ->setPersonalWebsite($domainName)
                ;
            })
        ;
    }
}
