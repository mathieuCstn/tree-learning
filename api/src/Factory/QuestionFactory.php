<?php

namespace App\Factory;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Question>
 */
final class QuestionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    public static function class(): string
    {
        return Question::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->randomElement($this->getQuestionTitles()),
            'content' => self::faker()->boolean(30) ? self::faker()->randomElement($this->getCodeSnippets()) : null,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Question $question): void {
                $numberOfChoice = rand(1, 5);
                $responsesIsCodeSnippets = self::faker()->boolean(10);

                ChoiceFactory::createOne([
                    'question' => $question,
                    'content' => $responsesIsCodeSnippets ? self::faker()->randomElement($this->getCodeSnippets()) : self::faker()->sentence(3),
                    'is_correct' => true,
                    'feedback' => self::faker()->text(40)
                ]);

                ChoiceFactory::createMany($numberOfChoice, [
                    'question' => $question,
                    'content' => $responsesIsCodeSnippets ? self::faker()->randomElement($this->getCodeSnippets()) : self::faker()->sentence(3),
                    'is_correct' => self::faker()->boolean(20),
                    'feedback' => self::faker()->text(40)
                ]);
            });
    }

    private function getQuestionTitles(): array
    {
        return [
            // PHP Basique et POO
            "Quelle est la différence entre une interface et une classe abstraite en PHP ?",
            "Comment fonctionne l'héritage multiple en PHP ?",
            "À quoi sert le mot-clé 'final' en PHP ?",
            "Quelle est l'utilité du type mixed en PHP 8 ?",
            "Pourquoi utiliser les attributs readonly en PHP ?",
            "Comment fonctionne la promotion de propriétés en PHP 8 ?",

            // PHP Avancé
            "Quelle est la différence entre __construct() et __invoke() ?",
            "Comment fonctionne la méthode magique __call() ?",
            "Pourquoi utiliser les générateurs en PHP ?",
            "Quelle est l'utilité du pattern Repository ?",
            "Comment fonctionne la sérialisation en PHP ?",
            "À quoi sert l'opérateur de coalescence nulle ?? ?",

            // Symfony
            "Comment fonctionne le système d'events dans Symfony ?",
            "Quelle est la différence entre un service et un contrôleur ?",
            "Comment configurer une relation ManyToMany avec Doctrine ?",
            "À quoi servent les Data Transformers dans Symfony ?",
            "Comment fonctionne le ParamConverter dans Symfony ?",
            "Pourquoi utiliser les Voters dans Symfony ?",

            // Base de données
            "Quelle est la différence entre INNER JOIN et LEFT JOIN ?",
            "Comment optimiser une requête avec beaucoup de JOIN ?",
            "Pourquoi utiliser les index dans une base de données ?",
            "Quelle est la différence entre DELETE et TRUNCATE ?",
            "Comment fonctionne une transaction SQL ?",
            "Pourquoi utiliser les procédures stockées ?",

            // Architecture et Patterns
            "Quelle est la différence entre MVC et ADR ?",
            "Comment implémenter le pattern Strategy ?",
            "Pourquoi utiliser le pattern Observer ?",
            "Comment fonctionne l'injection de dépendances ?",
            "Quelle est l'utilité du pattern Decorator ?",
            "Comment mettre en place une architecture hexagonale ?",

            // API et Sécurité
            "Comment fonctionne l'authentification JWT ?",
            "Quelle est la différence entre Authentication et Authorization ?",
            "Comment gérer le CORS dans une API REST ?",
            "Pourquoi utiliser GraphQL plutôt que REST ?",
            "Comment sécuriser une API avec OAuth2 ?",
            "Quelle est l'utilité du format HAL ?",

            // JavaScript et Frontend
            "Quelle est la différence entre let et const ?",
            "Comment fonctionne le hoisting en JavaScript ?",
            "Pourquoi utiliser les Promises en JavaScript ?",
            "Comment fonctionne l'Event Loop ?",
            "Quelle est la différence entre map et forEach ?",
            "Comment fonctionne le prototype en JavaScript ?",

            // Performance et Optimisation
            "Comment optimiser les performances d'une application Symfony ?",
            "Pourquoi utiliser Redis ou Memcached ?",
            "Comment mettre en place du cache HTTP ?",
            "Quelle est l'utilité du lazy loading ?",
            "Comment optimiser les requêtes N+1 ?",
            "Pourquoi utiliser un CDN ?",

            // Tests et Qualité
            "Quelle est la différence entre PHPUnit et Behat ?",
            "Comment mettre en place des tests fonctionnels ?",
            "Pourquoi utiliser le TDD ?",
            "Comment tester une API REST ?",
            "Quelle est l'utilité de PHPStan ?",
            "Comment configurer une intégration continue ?"
        ];
    }

    private function getCodeSnippets(): array
    {
        return [
            // Constructeur et promotion de propriétés
            <<<'PHP'
class User {
    public function __construct(
        private string $name = "John",
        private ?int $age = null
    ){}

    public function hello(): string
    {
        return "Hello {$this->name}";
    }
}

$user = new User();
echo $user->hello();
PHP,

            // Méthode magique __toString
            <<<'PHP'
class Product {
    public function __construct(
        private string $name,
        private float $price
    ){}

    public function __toString(): string
    {
        return "{$this->name} : {$this->price}€";
    }
}

$product = new Product("Livre", 29.99);
echo $product;
PHP,

            // Méthode magique __call
            <<<'PHP'
class Router {
    private array $routes = [];

    public function __call($name, $arguments)
    {
        $this->routes[$name] = $arguments[0];
    }
}

$router = new Router();
$router->get('/home');
var_dump($router);
PHP,

            // Générateur (yield)
            <<<'PHP'
function range(int $start, int $end): Generator
{
    for ($i = $start; $i <= $end; $i++) {
        yield $i => $i * 2;
    }
}

foreach (range(1, 3) as $key => $value) {
    echo "$key => $value\n";
}
PHP,

            // Callable et closure
            <<<'PHP'
$numbers = [1, 2, 3, 4, 5];
$double = fn($n) => $n * 2;

$result = array_map($double, $numbers);
print_r($result);
PHP,

            // Destructuration de tableau
            <<<'PHP'
$coords = [10, 20, 30];
[$x, $y, $z] = $coords;

$person = ['name' => 'Alice', 'age' => 25];
['name' => $name, 'age' => $age] = $person;

echo "$name est âgé de $age ans";
PHP,

            // Match expression
            <<<'PHP'
$status = 404;

$message = match($status) {
    200, 201 => 'Success',
    400 => 'Bad request',
    404 => 'Not found',
    default => 'Unknown status',
};

echo $message;
PHP,

            // Nullsafe operator
            <<<'PHP'
class Address {
    public function getCity(): ?string { return "Paris"; }
}

class User {
    public function __construct(
        private ?Address $address = null
    ){}

    public function getAddress(): ?Address { return $this->address; }
}

$user = new User();
echo $user?->getAddress()?->getCity();
PHP,

            // Named arguments
            <<<'PHP'
function createUser(
    string $name,
    string $email,
    bool $active = true,
    ?string $role = null
) {
    return compact('name', 'email', 'active', 'role');
}

$user = createUser(
    email: 'john@example.com',
    name: 'John',
    role: 'admin'
);

print_r($user);
PHP,

            // Traits et interfaces
            <<<'PHP'
interface Shareable {
    public function share(): string;
}

trait Timestamp {
    public function getTimestamp(): string {
        return date('Y-m-d H:i:s');
    }
}

class Post implements Shareable {
    use Timestamp;

    public function share(): string {
        return "Shared at " . $this->getTimestamp();
    }
}

$post = new Post();
echo $post->share();
PHP
        ];
    }
}
