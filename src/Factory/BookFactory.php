<?php

namespace App\Factory;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Book>
 *
 * @method static Book|Proxy createOne(array $attributes = [])
 * @method static Book[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Book|Proxy find(object|array|mixed $criteria)
 * @method static Book|Proxy findOrCreate(array $attributes)
 * @method static Book|Proxy first(string $sortedField = 'id')
 * @method static Book|Proxy last(string $sortedField = 'id')
 * @method static Book|Proxy random(array $attributes = [])
 * @method static Book|Proxy randomOrCreate(array $attributes = [])
 * @method static Book[]|Proxy[] all()
 * @method static Book[]|Proxy[] findBy(array $attributes)
 * @method static Book[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Book[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BookRepository|RepositoryProxy repository()
 * @method Book|Proxy create(array|callable $attributes = [])
 */
final class BookFactory extends ModelFactory
{
    private $authorRepository;
    public function __construct(AuthorRepository  $authorRepository)
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'title' => self::faker()->realTextBetween(5,10),
            'topic' => self::faker()->realTextBetween(12,70),
            'price' => self::faker()->numberBetween(25,490),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Book $book): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Book::class;
    }
}
